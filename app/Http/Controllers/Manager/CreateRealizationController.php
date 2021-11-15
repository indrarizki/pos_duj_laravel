<?php

namespace App\Http\Controllers\Manager;

use App\Realization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateRealizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function create_realization(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'numeric', 'gte:0'],
            'budgeting_id' => ['required', 'numeric', 'gte:0'],
        ]);



        $realizations = new Realization;
        // $product->id = $random_id;
        $realizations->name = $request->input('name');
        $realizations->nominal = $request->input('nominal');
        $realizations->budgeting_id = $request->input('budgeting_id');
        $realizations->save();

        return redirect()->route('manager.realization.ui');
    }
}
