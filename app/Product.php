<?php

namespace App;

use App\ReportProduct;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function warehouse_products()
    {
        return $this->belongsTo(WarehouseProduct::class, 'warehouse_product_id');
    }

    public function report_products()
    {
        return $this->hasMany(ReportProduct::class);
    }

    public static function decrease_product_quantity($product_id, $product_quantity, $customer_id, $staff_id)
    {

        $update_product = Product::where('id', '=', $product_id);

        // get value old quantity
        $old_quantity = $update_product->first()['quantity'];

        // new quantity value
        $new_quantity = $product_quantity;

        $sum_quantity = $old_quantity - $new_quantity;
        $payload = [
            'quantity' => $sum_quantity
        ];


        //get customer information
        $customer = Customer::where('id', '=', $customer_id)->first();

        $update_product->update($payload);

        $report_product = new ReportProduct;
        $report_product->product_id = $product_id;
        $report_product->in = 0;
        $report_product->out = $new_quantity;
        $report_product->information = 'Terjual ke ' . $customer->name . ' via ' . Auth::user()->name;
        $report_product->customer_id = $customer_id;
        $report_product->remainder = $sum_quantity;
        $report_product->save();

        // $report_product
    }

    public function transaction_product()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public static function search_product($search_query)
    {

        // $product =  Product::query()
        //     ->where('name', 'like', "%{$search_query}%")
        //     ->where('quantity', '>', 0)->get();

        $product =  Product::query()
            // ->where('name', 'like', "%{$search_query}%")
            ->where('is_deleted', '=', false)
            ->where('quantity', '>', 0)
            ->whereHas('warehouse_products', function ($query) use ($search_query) {
                $query->where('name', 'like', "%{$search_query}%");
            })
            ->with('warehouse_products')
            ->get();

        return $product;
    }
    public static function rulesProduct()
    {
        $roles = array(
            "sale" => "sale",
            "asset" => "asset",

        );
        return $roles;
    }
    public static function get_products($store_id = null, $product_id = null)
    {
        if ($store_id != null) {
            $data = Product::where('store_id', '=', $store_id)
                ->where('is_deleted', '=', false)
                ->with('warehouse_products')
                ->with('report_products')
                ->get();
            return $data;
        } else if ($product_id != null) {
            $data = Product::where('id', '=', $product_id)
                ->where('is_deleted', '=', false)
                ->with('warehouse_products')
                ->with('report_products')
                ->first();
            return $data;
        }
    }
}
