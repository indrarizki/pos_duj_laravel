<?php

namespace App\Http\Controllers\Resepsionist;

use App\AbsentCust;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateAbsentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }
    public function create_absent(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => ['required', 'numeric', 'gte:0'],
        ]);

        $absents = new AbsentCust;
        // $product->id = $random_id;
        $absents->customer_id = $request->input('customer_id');
        $absents->save();

        return redirect()->route('resepsionist.absent.ui');
    }
}
