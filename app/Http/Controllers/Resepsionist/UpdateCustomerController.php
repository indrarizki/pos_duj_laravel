<?php

namespace App\Http\Controllers\Resepsionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;

class UpdateCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function update_customer($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'numeric', 'gte:0'],
            'phone' => ['required', 'numeric', 'gte:0'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $update = array(
            'name' => $request->input('name'),
            'nik' => $request->input('nik'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address')
        );

        Customer::where('id', '=', $id)->update($update);

        return redirect()->route('resepsionist.customer.ui');
    }
}
