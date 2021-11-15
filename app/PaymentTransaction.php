<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentTransaction extends Model
{
    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->with('customers');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function absents_payment()
    {
        return $this->hasOne(AbsentsPayment::class);
    }


    public static function create_payment_transactions($id, $payment)
    {
        $transaction_product = new PaymentTransaction;
        $transaction_product->transaction_id = $id;
        $transaction_product->user_id = Auth::user()->id;
        $transaction_product->cost = $payment;
        $transaction_product->save();

        return $transaction_product;
    }

    public static function get_kasir_reports_by_date($user_id, $date_query)
    {
        $payment_transaction = PaymentTransaction::where('user_id', '=', $user_id)
            ->whereDate('created_at', $date_query)
            ->with('transactions')
            ->with('user')
            ->get();

        return $payment_transaction;
    }

    public static function get_reports_by_date($date_query)
    {
        $payment_transaction = PaymentTransaction::whereDate('created_at', $date_query)
            ->with('transactions')
            ->with('user')
            ->get();

        return $payment_transaction;
    }
}
