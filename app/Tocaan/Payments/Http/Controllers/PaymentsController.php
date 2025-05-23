<?php
namespace App\Tocaan\Payments\Http\Controllers;

use Illuminate\Http\Request;
use App\Tocaan\Payments\Payments;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Tocaan\Payments\Models\Transaction;

class PaymentsController extends Controller
{
    public function callback(Request $request)
    {
        abort_if( !$this->validateTr($request), 404 );

        $driver = base64_decode($request->driver);
        abort_if( is_null($driver), 404 );

        $transaction = Transaction::where('number', $request->transaction_number)
        ->where('paymentmethod_slug', $driver)
        ->whereStatus('pending')
        ->firstOrFail();

        return (new Payments($transaction->invoice) )->via($driver)->success($request);

        return redirect()->route('payments.failure');
    }

    public function failure(Request $request)
    {
        abort_if( !$this->validateTr($request), 404 );
        $driver = str_replace("%3D%3D?PaymentID", "", $request->driver);
        $driver = base64_decode($driver);  
        abort_if( is_null($driver), 404 );

        $transaction = Transaction::where('number', $request->transaction_number)
        ->where('paymentmethod_slug', $driver)
        ->whereStatus('pending')
        ->firstOrFail();

        return (new Payments($transaction->invoice) )->via($driver)->failure($request);
    }

    private function validateTr(Request $request)
    {
        if( !is_null( $request->transaction_number ) )
        {
            return true;
        }

        return false;
    }
}
