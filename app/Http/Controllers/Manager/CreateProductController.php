<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ReportProduct;
use App\WarehouseProduct;

class CreateProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function create_product($id, Request $request)
    {
        $product = Product::get_products(null, $id);
        $warehouse_product = $product->warehouse_products;
        $validatedData = $request->validate([
            'quantity' => ['required', 'numeric', 'gte:0', 'max:' . $warehouse_product->quantity],
        ]);

        Product::where('id', '=', $id)->update([
            'quantity' => $product->quantity + $request->input('quantity')
        ]);

        WarehouseProduct::where('id', '=', $warehouse_product->id)
            ->update(['quantity' => $warehouse_product->quantity - $request->input('quantity')]);

        $report_product = new ReportProduct;
        $report_product->product_id = $product->id;
        $report_product->in = $request->input('quantity');
        $report_product->remainder = $product->quantity + $request->input('quantity');
        $report_product->information = "Dari markas";
        $report_product->save();

        return redirect()->route('manager.stores.products.ui', $product->store_id);
    }

    public function create_warehouse_products(Request $request)
    {
        $random_id = strtoupper(Str::random(rand(1, 20)));

        $checkId = WarehouseProduct::where('id', '=', $random_id)->exists();
        if ($checkId) {
            return $this->create_warehouse_products($request);
        }
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'gte:0'],
            'quantity' => ['required', 'numeric', 'gte:0'],
        ]);


        // insert warehouse product
        $product = new WarehouseProduct;
        $product->id = $random_id;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->save();

        return redirect()->route('manager.warehouse.products.ui');
    }

    public function create_product_rest($store_id, Request $request)
    {
        // get from form
        $warehouse_product_id = $request['warehouse_product_id'];
        $quantity = $request['quantity'];
        $price = $request['price'];

        //get all informastion warehouse_product
        $warehouse_product =
            WarehouseProduct::where('id', '=', $warehouse_product_id)->first();

        if ($warehouse_product->quantity < $quantity) {
            return response()->json(['error' => 'barang gudang lebih sedikit dari input'], 400);
        }

        if ($quantity <= 0) {
            return response()->json(['error' => 'Masukkan jumlah'], 400);
        }

        // insert new product to store
        $product = new Product;
        $product->warehouse_product_id = $warehouse_product_id;
        $product->store_id = $store_id;
        $product->quantity = $quantity;
        $product->price = $price;
        $product->is_deleted = false;
        $product->save();

        //then decrease warehouse_products
        WarehouseProduct::where('id', '=', $warehouse_product_id)
            ->update(['quantity' => $warehouse_product->quantity - $quantity]);

        // then create report
        $report_product = new ReportProduct;
        $report_product->product_id = $product->id;
        $report_product->in = $quantity;
        $report_product->out = 0;
        $report_product->remainder = $quantity;
        $report_product->information = 'Dari Markas';
        $report_product->save();

        return response()->json(['success' => "berhasil insert product"], 200);
    }
}
