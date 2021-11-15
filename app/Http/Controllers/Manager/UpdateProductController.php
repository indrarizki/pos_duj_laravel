<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Product;
use App\ReportProduct;
use App\WarehouseProduct;
use Illuminate\Http\Request;

class UpdateProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }


    public function update_product($id, Request $request)
    {
        $product = Product::get_products(null, $id);
        $warehouse_product = $product->warehouse_products;
        $job = $request->input('job');

        if ($job == 'increase_quantity_product') {
            // handle increase product quantity
            $validatedData = $request->validate([
                'quantity' => ['required', 'numeric',  'gte:1', 'max:' . $warehouse_product->quantity],
            ]);

            Product::where('id', '=', $id)->update([
                'quantity' => $product->quantity + $request->input('quantity'),
                'is_deleted' =>  false
            ]);

            WarehouseProduct::where('id', '=', $warehouse_product->id)
                ->update(['quantity' => $warehouse_product->quantity - $request->input('quantity')]);


            $report_product = new ReportProduct;
            $report_product->product_id = $product->id;
            $report_product->in = $request->input('quantity');
            $report_product->remainder = $product->quantity + $request->input('quantity');
            $report_product->information = "Dari markas";

        } elseif ($job == 'move_quantity_product_to_warehouse') {
            $validatedData = $request->validate([
                'quantity' => ['required', 'numeric',  'gte:1', 'max:' . $product->quantity],
            ]);
            Product::where('id', '=', $id)->update([
                'quantity' => $product->quantity - $request->input('quantity'),
                'is_deleted' => false
            ]);
            $report_product = new ReportProduct;
            $report_product->product_id = $product->id;
            $report_product->out = $request->input('quantity');
            $report_product->remainder = $product->quantity - $request->input('quantity');
            $report_product->information = "Produk pindah ke markas";

        } elseif ($job == 'delete_product') {
            Product::where('id', '=', $id)->update([
                'quantity' => 0,
                'is_deleted' => true
            ]);

            $report_product = new ReportProduct;
            $report_product->product_id = $product->id;
            $report_product->remainder = 0;
            $report_product->information = "Produk terhapus";

        }
        $report_product->save();

        return redirect()->route('manager.stores.products.ui', $product->store_id);
    }

    public function update_warehouse_product($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gte:0'],
            'quantity' => ['required', 'numeric', 'gte:0'],
        ]);

        $update = array(
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        );

        WarehouseProduct::where('id', '=', $id)->update($update);

        return redirect()->route('manager.warehouse.products.ui');
    }
}
