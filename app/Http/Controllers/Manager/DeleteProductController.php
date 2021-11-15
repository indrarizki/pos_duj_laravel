<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Product;
use App\WarehouseProduct;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function delete_product($id)
    {
        Product::where('id', '=', $id)->update(
            [
                'is_deleted' => true,
                'quantity' => 0
            ]
        );
        return redirect()->route('manager.products.ui');
    }

    public function delete_warehouse_product($id)
    {
        WarehouseProduct::where('id', '=', $id)->update(
            [
                'is_deleted' => true,
                'quantity' => 0
            ]
        );
        return redirect()->route('manager.warehouse.products.ui');
    }
}
