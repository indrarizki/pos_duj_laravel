<?php

namespace App\Http\Controllers\Kasir;

use App\Customer;
use App\Http\Controllers\Controller;
use App\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Product;
use App\Refund;
use App\Staff;
use App\Transaction;
use App\User;
use Laravel\Passport\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class KasirController extends Controller
{

    public function __construct()
    {
        $this->middleware('role');
    }


    public function index()
    {
        $data = Product::all();
        return view('kasir.home',['products' => $data]);
    }

    public function get_work_mode()
    {
        $route_name = Route::currentRouteName();
        $base_url = url('');
        $access_token = User::get_access_token('Kasir');
        $payload = [
            'route' => $route_name,
            'base_url' => $base_url,
            'token' => $access_token
        ];
        return view('kasir.work_mode', $payload);
    }

    // public function get_products_api($id)
    // {
    //     $data = Product::where('id', '=', $id)->first();
    //     return response()->json($data, 200);
    // }

    public function get_all_products_api()
    {
        $data = Product::all();
        return response()->json($data, 200);
    }

    public function search_customer_api($search_query)
    {
        $data = Customer::search_customer($search_query);
        return response()->json($data, 200);
    }

    public function search_staff_api($search_query)
    {
        $data = Staff::search_staff($search_query);
        return response()->json($data, 200);
    }

    public function search_product_api($search_query)
    {
        $data = Product::search_product($search_query);
        return response()->json($data, 200);
    }

    public function get_transaction_rest($id)
    {
        $status = 200;
        $data = Transaction::get_transaction($id);
        if ($data == null) {
            $data = Customer::get_all_transactions($id);
        }
        $response = response()->json($data, $status);
        return $response;
    }

    public function payment()
    {
        $base_url = url('');
        $access_token = User::get_access_token('Kasir');
        $payload = [
            'base_url' => $base_url,
            'token' => $access_token
        ];
        return view('kasir.payment', $payload);
    }
    public function kasir_refund()
    {
        $base_url = url('');
        $access_token = User::get_access_token('Kasir');
        $payload = [
            'base_url' => $base_url,
            'token' => $access_token
        ];
        return view('kasir.refund', $payload);
    }

    public function kasir_reports()
    {
        $base_url = url('');
        $access_token = User::get_access_token('Kasir');
        $payload = [
            'base_url' => $base_url,
            'token' => $access_token
        ];
        return view('kasir.reports', $payload);
    }

    public function kasir_reports_rest_by_date($date_query)
    {
        $user_id = Auth()->user()->id;
        if ($date_query == 'today')  $date_query = Carbon::today();
        $reports = PaymentTransaction::get_kasir_reports_by_date($user_id, $date_query);

        return response()->json($reports, 200);
    }
    public function kasir_refunds_rest()
    {
        $reports = Refund::get_refunds();

        return response()->json($reports, 200);
    }

   
}
