<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Staff;
use App\Transaction;
use Illuminate\Http\Request;

class UpdateStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function update_staff($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'gte:0'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $update = array(
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address')
        );

        Staff::where('id', '=', $id)->update($update);

        return redirect()->route('manager.staff.ui');
    }

    public function change_staff($id, Request $request)
    {
        $validatedData = $request->validate([
            'staff_id' => ['required', 'numeric', 'gte:0'],
        ]);

        $update = array(
            'staff_id' => $request->input('staff_id'),
        );

        Transaction::where('id', '=', $id)->update($update);

        return response()->json($update, 200);
    }
}
