<?php

namespace App\Http\Controllers\Manager;
use App\Refund;
use App\Transaction;
use App\PaymentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateRefundController extends Controller
{
    public function validation_refund($id, Request $request)
    {
         $out = new \Symfony\Component\Console\Output\ConsoleOutput();
         $out->writeln($id);
         $out->writeln($request->is_refund_off);
        // $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $validatedData = $request->validate([
            'is_refund_off' => ['required', 'numeric', 'gte:0'],
        ]);

        $update = array(
            'is_refund_off' => $request->input('is_refund_off')
        );

        Refund::where('id', '=', $id)->update($update);

        return response()->json($update, 200);
    
    }
}
