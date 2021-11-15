<?php

namespace App\Http\Controllers\ManagerCenter;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::get_all_transactions();
        $context = [
            'transactions' => $data,
            'is_paid_off' =>  "all",
            'customer_id' => ""
        ];
        return view('manager_center.transaction', $context);
    }

    public function shows_transactions_filter_is_paid_off($boolean)
    {
        $data = Transaction::get_all_transactions_filter_is_paid_off($boolean);
        return view('manager_center.transaction', ['transactions' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $access_token = User::get_access_token("Manager Center");
        $base_url = url('');
        $payload = [
            'id' => $id,
            'token' => $access_token,
            'base_url' => $base_url,
        ];
        return view('manager_center.transaction_edit', $payload);
    }

    public function show_by_id_api($id)
    {
        $data = Transaction::get_transaction($id);
        $response = response()->json($data, 200);
        return $response;
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function show_search(Request $request )
    {
        $data =  Transaction::search($request);
        $context = [
            'transactions' => $data["transactions"],
            'is_paid_off' => $data["where_query"]['is_paid_off'] ?? "all",
            'customer_id' => $data["where_query"]['customer_id'] ?? "",
            'sort_type' => $data["sort_type"] ?? "desc",
            'date_time' => $data['where_query']['date_time'] ?? null
        ];
        return view('manager_center.transaction' ,$context );
    }
}
