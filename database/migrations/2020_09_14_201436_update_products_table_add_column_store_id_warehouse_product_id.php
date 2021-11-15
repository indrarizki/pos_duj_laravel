<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableAddColumnStoreIdWarehouseProductId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('store_id')->after('id')->constrained('stores');
            // $table->foreignId('warehouse_product_id')->after('id')->constrained();
            $table->string('warehouse_product_id')->after('id');
            $table->foreign('warehouse_product_id')->references('id')->on('warehouse_products');
            // $table->foreignId
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn(['store_id']);

            $table->dropForeign(['warehouse_product_id']);
            $table->dropColumn(['warehouse_product_id']);


        });
    }
}
