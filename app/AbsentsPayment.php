<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class AbsentsPayment extends Model
{
    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment_transactions()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
}
