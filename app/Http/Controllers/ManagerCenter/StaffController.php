<?php

namespace App\Http\Controllers\ManagerCenter;

use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
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
     
        $data = Staff::all();
        return view('manager_center.staff', ['staff' => $data]);
    
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
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $data = Staff::where('id', '=', $id)->first();
        // return view('resepsionist.staff_data', ['staff' => $data]);
        $staff = Staff::find($id);
        $transactions = $staff->transactions()->get();
        

        // $out->writeln($transactions);
        foreach ($transactions as $transaction) {
            // $out->writeln($value->id);
            $products = Staff::get_product_transaction($transaction->id);
            $transaction->products = $products;

            foreach ($transaction->products as $product) {
                // $out->writeln($product);
                $products = Staff::get_product($product->product_id);

                // $out->writeln($products);

                $warehouse = Staff::get_warehouse($products->warehouse_product_id);

                    // $out->writeln($warehouse->name);
                $name = $warehouse->name;

                $product->name = $name;
            }
        }
        return view('manager_center.staff_data', ['data' => $data , 'transactions' => $transactions]);   
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
}
