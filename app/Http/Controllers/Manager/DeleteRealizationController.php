<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Realization;

class DeleteRealizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('role');
    }

    public function delete_realization($id)
    {
        Realization::where('id', '=', $id)->delete();
        return redirect()->route('manager.realization.ui');
    }
}
