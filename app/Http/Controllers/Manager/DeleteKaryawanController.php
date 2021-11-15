<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class DeleteKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }


    public function deactivate_karyawan($id)
    {
        // User::where('id', '=', $id)->delete();
        User::where('id', '=', $id)->update(['is_active' => false]);
        return redirect()->route('manager.karyawan.ui');
    }

    public function activate_karyawan($id)
    {
        User::where('id', '=', $id)->update(['is_active' => true]);
        return redirect()->route('manager.karyawan.ui');
    }
}
