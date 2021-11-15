<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = "staffs";
    protected $fillable = ["name", "phone", "address", "photo"];

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'integer';

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function search_staff($search_query)
    {

        $staff =  Staff::query()
            ->where('name', 'like', "%{$search_query}%")
            ->orWhere('id', 'like', "%{$search_query}%")->get();
        return $staff;
    }

    public static function get_product_transaction($id)
    {
    //     // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $transactions = ProductTransaction::where('transaction_id', '=', $id)
    //         ->with('users')
            // ->with('customers')
    //         ->with('staffs')
            // ->with('product_transactions')
    //         ->with('payment_transactions')
    //         ->with('refund_transactions')
    //         // ->with('warehouse_products')
            ->get();
            return $transactions;
    }

    public static function get_product($id)
    {
        $product = Product::where('id', '=', $id)
            ->first();

        return $product;
    }

    public static function get_warehouse($id)
    {
        $warehouse = WarehouseProduct::where('id', '=', $id)
        ->first();

        return $warehouse;
    }
}
