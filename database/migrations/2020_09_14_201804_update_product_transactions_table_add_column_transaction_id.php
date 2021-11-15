<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductTransactionsTableAddColumnTransactionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            $table->string('transaction_id')->after('id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            // $table->foreignId('transaction_id')->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_transactions', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropColumn(['transaction_id']);
        });
    }
}
