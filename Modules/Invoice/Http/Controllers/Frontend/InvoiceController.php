<?php

namespace Modules\Invoice\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Tocaan\Payments\Payments;
use Illuminate\Routing\Controller;
use Modules\Invoice\Entities\Feed;
use Illuminate\Support\Facades\Hash;
use Modules\Invoice\Entities\Invoice;
use Modules\User\Entities\CustomToken;
use Illuminate\Support\Facades\Session;
use Modules\Invoice\Entities\InvoicePlugin;
use Monolog\Logger;
use ZipStream\File;

class InvoiceController extends Controller
{
    public function paymentLink(Request $request)
    {
        if( is_null($token = CustomToken::where('token', $request->token)->whereDate('expires_at', '>', today())->first()) )
        {
            return view('invoice::frontend.expired');
        }

        if( !is_null( $invoice = Invoice::where('id', $request->id)->where('number', $request->number)->first() ) )
        {
            if( $token->link->invoice->plugin->payment_status=='success' )
            {
                return view('invoice::frontend.already_paid', compact('invoice'));
            }

            return view('invoice::frontend.pay', compact('invoice'));
        }

        abort(404);
    }

    public function pay(Request $request)
    {
        if( is_null($token = CustomToken::where('token', $request->token)->whereDate('expires_at', '>', today())->first()) )
        {
            return view('invoice::frontend.expired');
        }

        if( !is_null( $invoice = \App\Tocaan\Payments\Models\Invoice::where('id', $request->id)->where('number', $request->number)->first() ) )
        {
            if( $token->link->invoice->plugin->payment_status=='success' )
            {
                return view('invoice::frontend.already_paid', compact('invoice'));
            }

            $payments = new Payments($invoice);
            $hash = hash('sha1', Hash::make(Str::random(64)));

            Session::put('be_ensure_invoice_hash', $hash, 30 * 60);

            $result = $payments->via('kpay')
                ->SuccessRedirect(route('web.invoice.success', ['id' => $invoice->id, 'number' => $invoice->number, 'token' => $request->token, 'hash' => $hash]))
                ->FailureRedirect(route('web.invoice.failure', ['id' => $invoice->id, 'number' => $invoice->number, 'token' => $request->token, 'hash' => $hash]))
                ->pay();

            $file = storage_path('logs/invoices/invoice-'.$invoice->id.'.json');
            $content = file_get_contents($file);

            if($content){
                $content = json_decode($content);
                $trackId = isset($content->trackId) ? $content->trackId : null;
                $invoice->transactions()->latest('id')->first()->update(['ref_id'=> $trackId]);
            }

            return $result;
        }

        abort(404);
    }

    public function success(Request $request)
    {
        if( is_null($token = CustomToken::where('token', $request->token)->whereDate('expires_at', '>', today())->first()) )
        {
            return view('invoice::frontend.expired');
        }

        if( !is_null( $invoice = Invoice::where('id', $request->id)->where('number', $request->number)->first() ) )
        {
            abort_if( is_null(Session::get('be_ensure_invoice_hash')), 404 );
            abort_if( is_null($request->hash), 404 );
            abort_if($request->hash != Session::get('be_ensure_invoice_hash'), 404 );

            if( $token->link->invoice->plugin->payment_status=='success' )
            {
                return view('invoice::frontend.already_paid', compact('invoice'));
            }

            $invoice->plugin->update(['payment_status' => 'success']);
            $invoice->update(['status' => 'paid']);
            $invoice->transactions()->latest('id')->update(['status'=>'complete']);

            //Register feed
            $this->feed(
                'Invoice #'.$invoice->number.' successfully charged, amount '.$invoice->amount.' K.D',
                'تم تحصيل الفاتورة رقم #'.$invoice->number.' المبلغ '.$invoice->amount.' دينار',
                'success',
            );

            return view('invoice::frontend.success', compact('invoice'));
        }

        abort(404);
    }

    public function failure(Request $request)
    {
        if( is_null($token = CustomToken::where('token', $request->token)->whereDate('expires_at', '>', today())->first()) )
        {
            return view('invoice::frontend.expired');
        }

        if( !is_null( $invoice = Invoice::where('id', $request->id)->where('number', $request->number)->first() ) )
        {
            abort_if( is_null(Session::get('be_ensure_invoice_hash')), 404 );
            abort_if( is_null($request->hash), 404 );
            abort_if($request->hash != Session::get('be_ensure_invoice_hash'), 404 );

            $invoice->plugin->update(['payment_status' => 'failed']);
            $invoice->update(['status' => 'unpaid']);
            $invoice->transactions()->latest('id')->update(['status'=>'incomplete']);

            //Register feed
            $this->feed(
                'Invoice #'.$invoice->number.' payments failed. Client phone number '.$invoice->user->mobile ?? '--',
                'فشل تحصيل الفاتورة رقم #'.$invoice->number.', رقم الهاتف '.$invoice->user->mobile ?? '--',
                'failed',
                'fa fa-bullhorn'
            );

            return view('invoice::frontend.failure', compact('invoice'));
        }

        abort(404);
    }

    protected function feed($feed_en, $feed_ar, $type=null, $icon=null)
    {
        Feed::create(
            [
                'feed' => ['en' => $feed_en, 'ar' => $feed_ar],
                'type' => $type ?? 'info',
                'icon' => $icon ?? 'fa fa-bell-o'
            ]
            );
    }
}
