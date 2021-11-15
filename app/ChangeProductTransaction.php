<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeProductTransaction extends Model
{
    protected $table = "change_products";
    protected $primaryKey = 'id'; // or null
    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->with('customers');
    }

    public static function create_change_product_transaction($transaction_id, $scanner, $customer_id)
    {
        $change_product = new ChangeProductTransaction();
        $change_product->scanner = $scanner;
        $change_product->transaction_id = $transaction_id;
        $change_product->customer_id = $customer_id;
        $change_product->save();
        return $change_product;
    }

    public static function update_information_change($product_transactions, $temporary)
    {

        $update = array(
            'is_change_off' => 1,
            'information' => $temporary->product_id . " Ganti Ke " . $product_transactions->product_id,
        );

        ChangeProductTransaction::where('transaction_id', '=', $product_transactions->transaction_id)->update($update);
    }
    
}
