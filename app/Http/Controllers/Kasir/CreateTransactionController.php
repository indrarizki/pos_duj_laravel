<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\PaymentTransaction;
use App\Product;
use App\ProductTransaction;
use App\Transaction;
use App\Refund;
use App\ChangeProductTransaction;
use App\Customer;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function create_transactions(Request $request)
    {
        $products_to_sell = $request['products_to_sell'];
        $total_price = $request['total_price'];
        $total_quantity = $request['total_quantity'];
        $customer_id = $request['customer'];
        $staff_id = $request['staff'];
        


        // check verif customer

        $customer =  DB::select('select * from fingers where id = ? limit 1', [$customer_id]);
        $is_payment_off = $customer[0]->is_payment_off;
        if ($is_payment_off == 0) {
            return response()->json(['error' => 'Customer Belum Verifikasi'], 400);
        }
        DB::update('update fingers set is_payment_off = 0 where id = ?', [$customer_id]);

        // temporary cost / payment
        $payment = $request['payment'];
        $is_paid_off = false;
        // create transaction db
        if ($total_price == $payment) $is_paid_off = true;
        // if ($payment > $total_price) {
        //     return response()->json(['error' => 'Pembayaran terlalu besar'], 400);
        // }

        $create_transaction = Transaction::create_transaction($customer_id, $is_paid_off, $staff_id);
        for ($i = 0; $i < count($products_to_sell); $i++) {
            // create transaction prFoduct
            $product = $products_to_sell[$i];
            $product_id = $product['id'];
            $product_quantity = $product['quantity'];
            ProductTransaction::create_product_transactions($product, $create_transaction);

            // decrase product quantity if is paid off true
            if ($is_paid_off) Product::decrease_product_quantity($product_id, $product_quantity, $customer_id, $staff_id);
        }
        // create payment transaction
        PaymentTransaction::create_payment_transactions($create_transaction->id, $payment);

        return response()->json($create_transaction, 201);
    }

    public function create_payment_transactions(Request $request)
    {
        $id = $request['id'];
        $total_cost = $request['total_cost'];
        $payment = $request['payment'];
        $customer_id = $request['customer_id'];
        $staff_id = $request['staff_id'];


        $customer =  DB::select('select * from fingers where id = ? limit 1', [$customer_id]);
        $is_payment_off = $customer[0]->is_payment_off;
        if ($is_payment_off == 0) {
            return response()->json(['error' => 'Customer Belum Verifikasi'], 400);
        }
        DB::update('update fingers set is_payment_off = 0 where id = ?', [$customer_id]);

        // if ($payment > $total_cost) {
        //     return response()->json(['error' => 'Pembayaran terlalu besar'], 400);
        // }
        $payment_transaction = PaymentTransaction::create_payment_transactions($id, $payment);

        $transaction = Transaction::get_transaction($id);


        $total_payment = 0;
        for ($i = 0; $i < count($transaction->payment_transactions); $i++) {
            $element = $transaction->payment_transactions[$i];
            $total_payment += $element['cost'];
        }
        Transaction::update_payment_transaction($id, $total_payment, $customer_id, $staff_id);

        return response()->json($transaction, 201);
    }

    public function create_refund_transactions(Request $request)
    {
        $customer_id = $request['customer_id'];
        $transaction_id = $request['transaction_id'];
        $scanner = $request['scanner'];

        $file = $request->file('scanner');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . "." . $extension;
        $file->move('refund', $filename);

        // $customer = Transaction::get_transaction($customer_id);
        $customer =  DB::select('select * from fingers where id = ? limit 1', [$customer_id]);
        $is_payment_off = $customer[0]->is_payment_off;
        if ($is_payment_off == 0) {
            return response()->json(['error' => 'Customer Belum Verifikasi'], 400);
        }
        DB::update('update fingers set is_payment_off = 0 where id = ?', [$customer_id]);

        $refund = Refund::create_refund_transaction($transaction_id, $filename, $customer_id);

        return response()->json($refund, 201);
    }

    public function create_change_product_transactions(Request $request)
    {
        $transaction_id = $request['transaction_id'];
        $scanner = $request['scanner'];
        $customer_id = $request['customer_id'];

        $file = $request->file('scanner');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . "." . $extension;
        $file->move('change_product', $filename);

        $customer =  DB::select('select * from fingers where id = ? limit 1', [$customer_id]);
        $is_payment_off = $customer[0]->is_payment_off;
        if ($is_payment_off == 0) {
            return response()->json(['error' => 'Customer Belum Verifikasi'], 400);
        }
        DB::update('update fingers set is_payment_off = 0 where id = ?', [$customer_id]);

        $change_product = ChangeProductTransaction::create_change_product_transaction($transaction_id, $filename, $customer_id);

        return response()->json($change_product, 201);
    }
}
