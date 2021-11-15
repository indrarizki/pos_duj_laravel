<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class CreateKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');

    }


    public function create_karyawan(Request $request)
    {
        $name =  $request->input('name');
        $email = $request->input('email');
        $address = $request->input('address');
        $role = $request->input('role');
        $password = $request->input('password');

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required']
        ]);

        $insert = array(
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'role' => $role,
            'password' => Hash::make($password)
        );

        User::create($insert);

        return redirect()->route('manager.karyawan.ui');
    }

}
