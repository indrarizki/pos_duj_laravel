<?php

namespace App\Http\Controllers\Manager;

use App\ChangeProduct;
use App\ChangeProductTransaction;
use App\ProductTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateChangeProductController extends Controller
{
    public function validation_changeProduct($id, Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => ['required', 'numeric', 'gte:0'],
            'quantity' => ['required', 'numeric', 'gte:0'],
            'product_price' => ['required', 'numeric', 'gte:0'],
            'total_price' => ['required', 'numeric', 'gte:0'],
        ]);

        $update = array(
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'product_price' => $request->input('product_price'),
            'total_price' => $request->input('total_price'),
        );

        //temporary data
        $temporary = ProductTransaction::where('id', '=', $id)->first();

        ProductTransaction::where('id', '=', $id)->update($update);

        $product_transactions = ProductTransaction::where('id', '=', $id)->first();
    
        ChangeProductTransaction::update_information_change($product_transactions, $temporary);

        return response()->json($update, 200);
    }
}
