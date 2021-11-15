<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $table = "refunds";
    protected $primaryKey = 'id'; // or null
    
    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->with('customers');
    }

   public static function create_refund_transaction($transaction_id, $scanner, $customer_id)
   {
       $refund = new Refund();
       $refund->scanner = $scanner;
       $refund->transaction_id = $transaction_id;
       $refund->customer_id = $customer_id;
       $refund->is_refund_off = 0;
       $refund->save();
       return $refund;
   }


    public static function get_refunds()
    {
        $refunds = Refund::with('transactions')
        ->get();

        return $refunds;
    }

}
