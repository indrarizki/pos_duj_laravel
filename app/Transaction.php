<?php

namespace App;

use App\WarehouseProduct;
use App\Staff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\ConsoleOutput;

class Transaction extends Model
{

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product_transactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public function staffs()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    // public function payment_transactions()
    // {
    //     return $this->hasMany(PaymentTransaction::class);
    // }

    public function payment_transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function refund_transactions()
    {
        return $this->hasOne(Refund::class);
    }
    public function change_product_transactions()
    {
        return $this->hasOne(ChangeProductTransaction::class);
    }

    public static function create_transaction(
        // $total_price,
        // $total_quantity,
        $customer_id,
        $is_paid_off = false,
        $staff_id
        // $payment
    ) {

        $random_id = strtoupper(Str::random(10));

        $checkId = Transaction::where('id', '=', $random_id)->exists();
        if ($checkId) {
            return  Transaction::create_transaction(
                // $total_price,
                // $total_quantity,

                $customer_id,
                $is_paid_off,
                $staff_id
                // $payment,
            );
        }
        $id = $random_id;

        $transaction = new Transaction;
        $transaction->id = $id;
        // $transaction->total_cost = $total_price;
        // $transaction->total_quantity = $total_quantity;
        $transaction->user_id = Auth::user()->id;

        $transaction->customer_id = $customer_id;
        $transaction->is_paid_off = $is_paid_off;
        $transaction->staff_id = $staff_id;
        // $transaction->payment = $payment;
        $transaction->save();
        return $transaction;
    }

    public static function get_all_transactions()
    {
        $transactions = Transaction::with('users')
            ->with('customers')
            ->with('staffs')
            ->with('refund_transactions')
            // ->with('product_transactions')
            // ->with('products')
            // ->with('warehouse_products')
            ->paginate(20);

        return $transactions;
    }

    public static function get_by_customer_id($customer_id)
    {

        $transactions = Transaction::where('customer_id', '=', $customer_id)->with('users')
            ->with('customers')
            ->with('staffs')
            ->with('refund_transactions')
            // ->with('product_transactions')
            // ->with('products')
            // ->with('warehouse_products')
            ->paginate(20);

        return $transactions;
    }

    public static function search($request)
    {
        $where_query = [];
        $customer_id = $request->customer_id;
        $is_paid_off = $request->is_paid_off;
        $sort_type = $request->sort_type ?? "desc";
        $date_time = $request->date_time ?? null;
        if ($customer_id != null) $where_query['customer_id'] = $customer_id;
        if ($is_paid_off != null && $is_paid_off != "all") $where_query['is_paid_off'] = $is_paid_off;


        // $where_query = ['field' => 'value', 'another_field' => 'another_value', ...];
        $transactions = Transaction::where($where_query);
        if ($date_time != null) {
            $where_query['date_time'] = $date_time;
            $transactions = $transactions->whereDate('created_at', '=', $where_query['date_time']);
        }
        $transactions = $transactions
            ->with('users')
            ->with('customers')
            ->with('staffs')
            ->with('refund_transactions')
            // ->with('product_transactions')
            // ->with('products')
            // ->with('warehouse_products')
            ->orderBy('created_at', $sort_type)

            ->paginate(10);

        $data = [];
        $data['transactions'] = $transactions;
        $data['where_query'] = $where_query;
        $data['sort_type'] = $sort_type;
        return $data;
    }

    public static function get_all_transactions_filter_is_paid_off($boolean)
    {
        $transactions = Transaction::where('is_paid_off', '=',  $boolean)
            ->with('users')
            ->with('customers')
            ->with('staffs')
            ->paginate(15);

        return $transactions;
    }

    public static function get_transaction($id)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $transactions = Transaction::where('id', '=', $id)
            ->with('users')
            ->with('customers')
            ->with('staffs')
            ->with('product_transactions')
            ->with('payment_transactions')
            ->with('refund_transactions')
            // ->with('warehouse_products')
            ->first();


        if ($transactions != null) {
            foreach ($transactions->product_transactions as $product) {
                $warehouse_product_id = $product->products->warehouse_product_id;
                $query_product = WarehouseProduct::where('id', '=', $warehouse_product_id)
                    ->first();
                // $out->writeln($query_product);
                $product->products->warehouse_product = $query_product;
                // $out->writeln($product);
            }
        }

        // ->with()

        return $transactions;
    }

    public static function  update_payment_transaction($id, $payment, $customer_id, $staff_id)
    {
        // update payment
        // $transactions = Transaction::where('id', '=', $id)
        //     ->update(['payment' => $payment]);


        // $total_cost = Transaction::get_transaction($id)->total_cost;

        $output = new ConsoleOutput();

        $products_transaction = ProductTransaction::get_product_transaction($id);

        $total_cost = 0;
        foreach ($products_transaction as $product) {
            $product_price = $product->product_price;
            $quantity = $product->quantity;
            $total_cost += ($product_price * $quantity);
        }
        $output->writeln($total_cost);


        if ($total_cost <= $payment) {
            // update is paid off
            $transactions = Transaction::where('id', '=', $id)
                ->update(['is_paid_off' => true]);

            $transaction =  Transaction::get_transaction($id);
            for ($i = 0; $i < count($transaction->product_transactions); $i++) {

                $product_id = $transaction->product_transactions[$i]['product_id'];
                $product_quantity = $transaction->product_transactions[$i]['quantity'];
                Product::decrease_product_quantity($product_id, $product_quantity, $customer_id, $staff_id);
            }
            return $transactions;
        }
    }

    public static function refund_transaction($id, $customer_id, $total_quantity)
    {
        $transactions = Transaction::where('id', '=', $id);
    }
}
