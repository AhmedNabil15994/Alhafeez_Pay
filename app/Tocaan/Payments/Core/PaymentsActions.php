<?php
namespace App\Tocaan\Payments\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentsActions
{
    /**
     * The success actions
     * @var Request $request
     */
    public function success(Request $request)
    {
        abort_if( !$this->validate($request), 404 );

        //update invoice status to paid
        $this->getInvoice()->status = 'paid';
        $this->getInvoice()->save();

        //update transaction status to complete
        $this->getInvoice()->activeTransaction->status = 'complete';
        $this->getInvoice()->activeTransaction->paymentmethod_slug = $this->getDriver();
        $this->getInvoice()->activeTransaction->tracking_data = json_encode( $request->all() );
        $this->getInvoice()->activeTransaction->save();

        //redirect to the success URL
        return $this->redirect('success');
    }

    public function failure(Request $request)
    {
        abort_if( !$this->validate($request), 404 );

        //update transaction status to incomplete
        //the next retry of the payment process, there is an automatic way to re-generate new pending transaction
        $this->getInvoice()->activeTransaction->status = 'incomplete';
        $this->getInvoice()->activeTransaction->paymentmethod_slug = $this->getDriver();
        $this->getInvoice()->activeTransaction->tracking_data = json_encode( $request->all() );
        $this->getInvoice()->activeTransaction->save();

        return $this->redirect('failure');
    }

    /**
     * Redirect to
     * @var string $for (success | failure)
     */
    public function redirect($for="success")
    {
        $prev = Session::get('prev_url');
        $success = Session::get('success_redirect_to');
        $failure = Session::get('failure_redirect_to');

        //Success redirect, Congracts!
        if( $for=="success" )
        {
            if( !is_null($success) )
            {
                Session::forget('success_redirect_to');
                return redirect()->to($success);
            } else {
                if( !is_null($this->urlsFromFile()) && isset($this->urlsFromFile()->success_url) )
                {
                    return redirect()->to($this->urlsFromFile()->success_url);
                }
            }
        }

        //Failure redirect, Sorry!
        if( $for=="failure" )
        {
            if( !is_null($failure) )
            {
                Session::forget('failure_redirect_to');
                return redirect()->to($failure);
            } else {
                if( !is_null($this->urlsFromFile()) && isset($this->urlsFromFile()->failure_url) )
                {
                    return redirect()->to($this->urlsFromFile()->failure_url);
                }
            }
        }

        //Default redirect to the previous URL
        if( is_null($prev) )
        {
            return redirect()->to('/');
        }

        return redirect()->to($prev);
    }

    protected function urlsFromFile()
    {
        $file = storage_path('logs/invoices/invoice-'.$this->getInvoice()->id.'.json');

        if( \File::exists($file) )
        {
            $json = \File::get($file);
            $data = json_decode($json);

            Session::put('be_ensure_invoice_hash', $data->hash, 30 * 60);
            return $data;
        }

        return null;
    }

    private function validate(Request $request)
    {
        if( $request->transaction_number==$this->getInvoice()->activeTransaction->number &&
        $request->driver = base64_encode( $this->getDriver() ) )
        {
            return true;
        }

        return false;
    }
}
