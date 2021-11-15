<?php

namespace App\Http\Controllers\Manager;

use App\Budgeting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateBudgetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function create_budgeting(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'numeric', 'gte:0'],
        ]);



        $budgetings = new Budgeting;
        // $product->id = $random_id;
        $budgetings->name = $request->input('name');
        $budgetings->nominal = $request->input('nominal');
        $budgetings->save();

        return redirect()->route('manager.budgeting.ui');
    }


}
