<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Budgeting;

class UpdateBudgetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function update_budgeting($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'numeric', 'gte:0'],
        ]);

        $update = array(
            'name' => $request->input('name'),
            'nominal' => $request->input('nominal')
        );

        Budgeting::where('id', '=', $id)->update($update);

        return redirect()->route('manager.budgeting.ui');
    }
}
