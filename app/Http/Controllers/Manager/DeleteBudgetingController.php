<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Budgeting;

class DeleteBudgetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function delete_budgeting($id)
    {
        Budgeting::where('id', '=', $id)->delete();
        return redirect()->route('manager.budgeting.ui');
    }
}
