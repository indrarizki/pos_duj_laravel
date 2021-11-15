<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsChangeOffAndInformationToChangeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_products', function (Blueprint $table) {
            $table->boolean('is_change_off')->default(false)->after('customer_id');
            $table->text('information')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('change_products', function (Blueprint $table) {
            $table->dropColoumn('is_change_off');
            $table->dropColoumn('information');
        });
    }
}
