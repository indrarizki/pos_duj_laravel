<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use App\PaymentTransaction;
use Illuminate\Http\Request;
use App\User;
class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function index()
    {
        $access_token = User::get_access_token("Manager");
        $base_url = url('/');
        $payload = [
            'token' => $access_token,
            'base_url' => $base_url,
        ];
        return view('manager.report_payment', $payload);
    }

    public function get_payments($date_query)
    {
        $payment_transaction = PaymentTransaction::get_reports_by_date($date_query);
        return response()->json($payment_transaction, 200);
    }
}
