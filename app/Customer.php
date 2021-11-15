<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Customer extends Model
{
    protected $table = "customers";
    protected $fillable = ["name","phone","address","photo"];

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'integer';

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function finger()
    {
        return $this->hasOne(Finger::class, 'id');
    }

    public function absents()
    {
        return $this->hasMany(AbsentCust::class, 'id');
    }

    public function absents_payment()
    {
        return $this->hasMany(AbsentsPayment::class, 'id');
    }

    public static function search_customer($search_query)
    {

        $customer =  Customer::query()
            ->where('name', 'like', "%{$search_query}%")
            ->orWhere('id', 'like', "%{$search_query}%")->paginate();
        return $customer;
    }

    public static function getAllCustomers() {
        $customer = Customer::with('finger')->paginate(100);
        // $customer = Customer::all();
        return $customer;
    }

    public static function get_all_transactions($id)
    {
        $transaction = Customer::where('id', '=', $id)
            ->with('transactions')
            // ->with('product_transactions')
            ->first();

        return $transaction;
    }

    public static function get_all_absent($id)
    {
        $absents = Customer::where('id', '=', $id)
        ->with('absents')->first();

        return $absents;
    }

    public static function search($request)
    {
        $where_query = [];
        $id = $request->id;
        $sort_type = $request->sort_type ?? "desc";
        $date_time = $request->date_time ?? null;
        if ($id != null) $where_query['id'] = $id;

        // $where_query = ['field' => 'value', 'another_field' => 'another_value', ...];
        $customers = Customer::where($where_query);
        if ($date_time != null) {
            $where_query['date_time'] = $date_time;
            $customers = $customers->whereDate('created_at', '=', $where_query['date_time']);
        }
        $customers = $customers
            ->with('finger')
            ->orderBy('created_at', $sort_type)
            ->paginate(100);
        
        $data = [];
        $data['customers'] = $customers;
        $data['where_query'] = $where_query;
        $data['sort_type'] = $sort_type;
        return $data;
    }
}
