<?php

namespace App\Http\Controllers\Resepsionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;

class DeleteCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function delete_customer($id)
    {
        Customer::where('id', '=', $id)->delete();
        return redirect()->route('resepsionist.customer.ui');
    }
}
