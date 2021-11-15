<?php

namespace App\Http\Controllers\Resepsionist;
use App\Customer;
use App\AbsentCust;
use App\flexcodesdk;

use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\DNS1D;
use Barryvdh\DomPDF\PDF;
// use Milon\Barcode\DNS2D;

class ResepsionistController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function index()
    {

        return view('resepsionist.home');
    }

    public function get_customer()
    {

        // $data = DB::table('customers')->paginate(50);
        $data = Customer::getAllCustomers();
        $context = [
            'customers' => $data,
            'date_time' => $data,
            'sort_type' => $data,
            'id' => ""
        ];
        return view('resepsionist.customer', $context);
    }
    public function get_customer_create()
    {
        return view('resepsionist.customer_create');
    }

    
    public function get_customer_edit($id)
    {
        $data = Customer::where('id', '=', $id)->first();
        return view('resepsionist.customer_edit', ['customer' => $data]);
    }

    public function cari_customer(Request $request)
    {
        $cari = $request->cari;
        $data = Customer::where('name','like',"%".$cari."%")
        ->orWhere('id', 'like', "%{$cari}%")->paginate(100);

        return view ('resepsionist.customer', ['customer' => $data]);
    }

    public function profile_customer($id)
    {
        $data = Customer::where('id', '=', $id)->first();
        $customers = Customer::find($id);
        $absent = $customers->absents()->get();
        return view('resepsionist.customerProfil', ['customer' => $data, 'absent' => $absent]);
    }
    public function customer_print()
    {
        return view('resepsionist.customer_code_print');
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
        return view('resepsionist.customer', $context);
    }

    public function form_absent()
    {
        return view('resepsionist.absent');
    }
    public function get_absents()
    {
        $data = AbsentCust::paginate(100);
        $context = [
            'absentcusts' => $data,
            'date_time' => $data,
            'sort_type' => $data,
        ];
        return view('resepsionist.customer_absent', $context);
    }
    public function show_search_absent(Request $request)
    {
        $data =  AbsentCust::search($request);
        $context = [
            'absentcusts' => $data["absentcusts"],
            'sort_type' => $data["sort_type"] ?? "desc",
            'date_time' => $data['where_query']['date_time'] ?? null
        ];
        return view('resepsionist.customer_absent', $context);
    }

    function data_range(Request $request){
        if(request()->ajax())
            {
            if(!empty($request->from_date))
            {
            $data = AbsentCust::whereBetween('log_time', array($request->from_date, $request->to_date))
                ->get();
            }
            else
            {
            $data = AbsentCust::get();
            }
            return datatables()->of($data)->make(true);
        }
        return view('resepsionist.customer_absent');
    }

    public function cek_absents($id){
         $customers = Customer::find($id);
         $absent = $customers->absents()->get();
        return view('resepsionist.absent_cek', compact('absent'));
        // return $data;
    }
    public function get_staff()
    {
        $data = Staff::all();
        return view('resepsionist.staff', ['staff' => $data]);
    }
    public function get_data_staff($id)
    {
        $data = Staff::where('id', '=', $id)->first();
        $staff= Staff::find($id);
        $transactions = $staff->transactions()->get();
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
        return view('resepsionist.staff_data', ['data' => $data , 'transactions' => $transactions]);
    }
public static function print_barcode($id)
{
    $data = Customer::where('id', '=', $id)->first();
    $barcode = DNS1D::getBarcodePNG($data, 'C39+');
        $customPaper = array(0, 0, 567.00, 283.80);
    $pdf = PDF::loadView('resepsionist.barcode', compact('barcode'))->setPaper($customPaper);
    return $pdf->stream();
}

}
