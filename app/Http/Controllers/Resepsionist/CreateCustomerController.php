<?php

namespace App\Http\Controllers\Resepsionist;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }
    public function create_customer(Request $request)
    {
        // $random_id = Int::random(10);
        // $checkId = Customer::where('id', '=', $random_id)->exists();
        // if ($checkId) {
        //     return $this->create_customer($request);
        // }
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'numeric', 'gte:0'],
            'phone' => ['required', 'numeric', 'gte:0'],
            'address' => ['required', 'string', 'max:255'],
            'photo' => ['required','image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);

        $customers = new Customer;
        // $customers->id = $random_id;
        $customers->name = $request->input('name');
        $customers->id = $request->input('nik');
        $customers->phone = $request->input('phone');
        $customers->address = $request->input('address');

        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "." . $extension;
            $file->move('customer', $filename);
            $customers->photo = $filename;
        }else{
            return $request;
            $customers->image = "";
        }
        $customers->save();

        return redirect()->route('resepsionist.customer.ui');
    }
}
