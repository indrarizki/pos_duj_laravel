<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UpdateKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }


    public function update_karyawan($id, Request $request)
    {

        $name =  $request->input('name');
        $email = $request->input('email');
        $address = $request->input('address');
        $is_active = $request->input('is_active');
        $role = $request->input('role');
        $oldInfo = User::where('id', '=', $id)->first();

        if ($email == $oldInfo->email) {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'role' => '',
                'is_active' => ''
            ]);
        } else {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'address' => ['required', 'string', 'max:255'],
                'role' => '',
                'is_active' => ''
            ]);
        }
        User::where('id', '=', $id)->update($validatedData);

        return redirect()->route('manager.karyawan.ui');
    }
}
