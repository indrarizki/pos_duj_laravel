<?php

namespace App\Http\Controllers\ManagerCenter;

use App\ChangeProductTransaction;
use App\Http\Controllers\Controller;
use App\Refund;
use Illuminate\Http\Request;

class DokumentRefundController extends Controller
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
        $refund_validation = Refund::where('is_refund_off', '=', true)->get();
        $refund = Refund::where('is_refund_off', '=', false)->get();
        $change_validation = ChangeProductTransaction::where('is_change_off', '=', true)->get();
        $change = ChangeProductTransaction::where('is_change_off', '=', false)->get();
        return view('manager_center.refund_pindah', compact("refund_validation", "refund", "change", "change_validation"));
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
        $data = Refund::find($id);
        return view('manager_center.refund_show', compact('data'));
    }

    public function change_show($id)
    {
        $data = ChangeProductTransaction::find($id);
        return view('manager_center.change_show', compact('data'));
    }

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
