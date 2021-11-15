<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Http\Request;

class DeleteStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function delete_staff($id)
    {
        Staff::where('id', '=', $id)->delete();
        return redirect()->route('manager.staff.ui');
    }
}
