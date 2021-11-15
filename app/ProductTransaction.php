<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTransaction extends Model
{



    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function create_product_transactions($product, $transaction)
    {
        $transaction_product = new ProductTransaction;
        $transaction_product->transaction_id = $transaction->id;
        $transaction_product->product_id = $product['id'];
        $transaction_product->quantity = $product['quantity'];
        $transaction_product->product_price = $product['price'];
        $transaction_product->total_price = $product['quantity'] * $product['price'];
        $transaction_product->save();
        return $transaction;
    }

    public static function get_product_transaction($id)
    {
        $transaction_products = ProductTransaction::where('transaction_id', '=', $id)
            ->get();

        return $transaction_products;
    }
}
