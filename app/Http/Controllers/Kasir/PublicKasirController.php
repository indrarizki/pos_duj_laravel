<?php

namespace App\Http\Controllers\Kasir;


use App\Http\Controllers\Controller;
use App\Jobs\Kasir\JobPublicKasirController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PublicKasirController extends Controller
{
    public function verif_payment($id)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($id);
        // $sq1         = "UPDATE fingers SET is_payment_off = '" . $is_payment_off . "' WHERE id = '" . $id . "'";
        DB::update('update fingers set is_payment_off = 1 where id = ?', [$id]);
        // $job = JobPublicKasirController::create()

        JobPublicKasirController::dispatch($id)->delay(now()->addSeconds(15));
       
        
    }
}
