<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Http\Request;

class CreateStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function create_staff(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'gte:0'],
            'address' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);



        $staff = new Staff;

        $staff->name = $request->input('name');
        $staff->phone = $request->input('phone');
        $staff->address = $request->input('address');

        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "." . $extension;
            $file->move('staff', $filename);
            $staff->photo = $filename;
        } else {
            return $request;
            $staff->image = "";
        }
        $staff->save();

        return redirect()->route('manager.staff.ui');
    }
}
