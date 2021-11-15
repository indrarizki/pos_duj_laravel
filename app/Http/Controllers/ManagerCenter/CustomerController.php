<?php

namespace App\Http\Controllers\ManagerCenter;

use App\AbsentCust;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
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

        $data = Customer::getAllCustomers();
        $context = [
                'customers' => $data,
                'date_time' => $data,
                'sort_type' => $data,
                'id' => ""
            ];
        return view('manager_center.customer', $context);
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
    public function show()
    {
        
    }

    public function show_search(Request $request)
    {
        $data =  Customer::search($request);
        $context = [
            'customers' => $data["customers"],
            // 'is_paid_off' => $data["where_query"]['is_paid_off'] ?? "all",
            'id' => $data["where_query"]['id'] ?? "",
            'sort_type' => $data["sort_type"] ?? "desc",
            'date_time' => $data['where_query']['date_time'] ?? null
        ];
        return view('manager_center.customer', $context);
    }


    public function show_by_name(Request $request)
    {
        // $data =  CustomerController::search($request);
        // $context = [
        //     'customers' => $data["customers"],
        //     'id' => $data["where_query"]['id'] ?? "",
        //     'sort_type' => $data["sort_type"] ?? "desc",
        //     'date_time' => $data['where_query']['date_time'] ?? null
        // ];
        // return view('manager_center.customer', $context);
        $cari = $request->cari;
        $data = Customer::where('name', 'like', "%" . $cari . "%")->paginate();

        return view('manager_center.customer', ['customer' => $data]);
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

    public function cek_absent($id)
    {

        $customer = Customer::find($id);
        $absent = $customer->absents()->get();
        return view('manager_center.customer_cek_absent', compact('absent'));
    }

    public function shows_absent()
    {
        $data = AbsentCust::paginate(100);
        $context = [
            'absentcusts' => $data,
            'date_time' => $data,
            'sort_type' => $data,
        ];
        return view('manager_center.customer_absent', $context);
    }

    public function show_search_absent(Request $request)
    {
        $data =  AbsentCust::search($request);
        $context = [
            'absentcusts' => $data["absentcusts"],
            'sort_type' => $data["sort_type"] ?? "desc",
            'date_time' => $data['where_query']['date_time'] ?? null
        ];
        return view('manager_center.customer_absent', $context);
    }

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
}
