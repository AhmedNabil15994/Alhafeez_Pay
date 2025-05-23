<?php
namespace App\Tocaan\Payments\Core\Gateways;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Tocaan\Payments\Core\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Tocaan\Payments\Models\Invoice;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Tocaan\Payments\Core\LoadDriver;
use App\Tocaan\Payments\Core\PaymentsBase;
use App\Tocaan\Payments\Core\PaymentsActions;
use App\Tocaan\Payments\traits\KpaySecurityTrait;
use App\Tocaan\Payments\Core\Contracts\GatewayContract;

class KPay extends PaymentsActions implements GatewayContract
{
    use KpaySecurityTrait;

    const DRIVER = 'kpay';
    private array $driver;
    private $fields;
    private $invoice;
    protected array $ExtraMerchantsData;
    private $paymentUrl = 'id={id}&password={password}&action=1&langid={lang}&currencycode=414&amt={amt}&responseURL={responseURL}&errorURL={errorURL}&trackid={trackid}&udf1={udf1}&udf2={udf2}&udf3={udf3}&udf4={udf4}&udf5={udf5}';
    private $tranportal_id; //get it from the bank terminal
    private $password; //get it from the bank terminal
    private $resource_key; //get it from the bank terminal
    private $GatewayUrl;

    public function __construct()
    {
        $this->driver = (new LoadDriver( self::DRIVER ))->resolve();
        $this->client = new Client;

        $this->tranportal_id = $this->driver['credentials']['tranportal_id'];
        $this->password = $this->driver['credentials']['password'];
        $this->resource_key = $this->driver['credentials']['resource_key'];

        $this->GatewayUrl = config('payments.sandbox') ? $this->driver['sandbox_url'] : $this->driver['live_url'];
    }

    public function setInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function getDriver()
    {
        return self::DRIVER;
    }

    public function pay(null|array $credentials): null|RedirectResponse
    {
        (new PaymentsBase($this->invoice))->buildTransaction(self::DRIVER);

        $this->formatUrlParames();
        $this->setUrls();

        if( isset($this->request()['url']) )
        {
            return redirect()->to($this->request()['url']);
        }

        return null;
    }

    protected function setUrls()
    {
        $success = Session::get('success_redirect_to');
        $failure = Session::get('failure_redirect_to');
        $hash = Session::get('be_ensure_invoice_hash');

        $file = storage_path('logs/invoices/invoice-'.$this->invoice->id.'.json');

        $data = [
            'success_url' => $success,
            'failure_url' => $failure,
            'hash' => $hash,
            'trackId' => $this->trackId,
        ];

        \File::put($file, json_encode($data));
    }

    /**
     * prepare pay url parames to kent
     * this update pay url var
     *
     */
    private function formatUrlParames()
    {
        $this->trackId = $this->invoice->activeTransaction()->number ?? time() . rand(1000, 100000);
        $user_id = $this->invoice->user->id;
        $this->mobile = $this->invoice->user->phone_code . $this->invoice->user->mobile;
        $this->email = $this->invoice->user->email;

        $this->responseURL = $this->fields()['success_url'];
        $this->errorURL = $this->fields()['error_url'];

        $replace_array = array();
        $replace_array['{id}'] = $this->tranportal_id . $this->invoice->user->name;
        $replace_array['{password}'] = $this->password;
        $replace_array['{amt}'] = $this->invoice->total;
        $replace_array['{trackid}'] = $this->trackId;
        $replace_array['{responseURL}'] = $this->responseURL;
        $replace_array['{errorURL}'] = $this->errorURL;
        $replace_array['{lang}'] = app()->getLocale() ?? 'ar';
        $replace_array['{udf1}'] = $this->invoice->id;
        $replace_array['{udf2}'] = $this->invoice->user->name ?? 'Online Client';
        $replace_array['{udf3}'] = $this->mobile;
        $replace_array['{udf4}'] = $this->mobile;
        $replace_array['{udf5}'] = $this->email;

        $this->paymentUrl = str_replace(array_keys($replace_array), array_values($replace_array), $this->paymentUrl);
    }

    /**
     * return pay url to redirect to knet gateway website
     * return array
     *
     *
     * @return array
     */
    public function request()
    {
        $this->formatUrlParames();
        $param = $this->encryptAES($this->paymentUrl, $this->resource_key) . "&tranportalId=" . $this->tranportal_id . "&responseURL=" . $this->responseURL . "&errorURL=" . $this->errorURL;
        $payURL = $this->GatewayUrl . "kpg/PaymentHTTP.htm?param=paymentInit" . "&trandata=" . $param;

        return [
            'status' => 'success',
            'url' => $payURL,
            'payment_id' => $this->trackId
        ];
    }

    protected function fields()
    {
        $fields =
        [
            'order_id' => $this->order_id ?? $this->invoice->number,
            'total_price' => $this->total ?? $this->invoice->total,
            'CurrencyCode' => $this->currency ?? 'kwd',
            'success_url' => $this->success_url ?? route('payments.callback',
                            [
                                'transaction_number' => $this->invoice->activeTransaction->number,
                                'driver' => base64_encode(self::DRIVER)
                            ]),
            'error_url' => $this->error_url ?? route('payments.failure',
                            [
                                'transaction_number' => $this->invoice->activeTransaction->number,
                                'driver' => base64_encode(self::DRIVER)
                            ]),
            'test_mode' => $this->driver['sandbox'] ?? true,
            'ProductTitle' => $this->product_title ?? $this->invoice->description,
        ];

        return $fields;
    }

    public function success(Request $request)
    {
        if( $this->response($request) )
        {
            return redirect()->to($this->urlsFromFile()->success_url);
        }

        return redirect()->to($this->urlsFromFile()->failure_url);
    }

    private function response(Request $request)
    {
        $ResErrorText = $request->ErrorText;
        $ResPaymentId = $request->paymentid;
        $ResTrackID = $request->trackid;
        $ResErrorNo = $request->Error;
        $ResResult = $request->result;
        $ResPosdate = $request->postdate;
        $ResTranId = $request->tranid;
        $ResAuth = $request->auth;
        $ResAVR = $request->avr;
        $ResRef = $request->ref;
        $ResAmount = $request->amt;
        $Resudf1 = $request->udf1;
        $Resudf2 = $request->udf2;
        $Resudf3 = $request->udf3;
        $Resudf4 = $request->udf4;
        $Resudf5 = $request->udf5;

        if ($ResErrorText == null && $ResErrorNo == null && $ResPaymentId != null)
        {
            $ResTranData = $request->trandata;
            $decrytedData = $this->decrypt($ResTranData, $this->resource_key);
            parse_str($decrytedData, $output);

            if( isset($output['result']) && !is_null($output['result']) && Str::upper($output['result'])=='CAPTURED')
            {
                return true;
            }
        }

        return false;
    }
    /**
     * get responce came from kney payment
     * return array()
     */
    private function responce()
    {

        $ResErrorText = (isset($_REQUEST['ErrorText'])) ? strip_tags($_REQUEST['ErrorText']) : null;        //Error Text/message
        $ResPaymentId = (isset($_REQUEST['paymentid'])) ? strip_tags($_REQUEST['paymentid']) : null;        //Payment Id
        $ResTrackID = (isset($_REQUEST['trackid'])) ? strip_tags($_REQUEST['trackid']) : null;        //Merchant Track ID
        $ResErrorNo = (isset($_REQUEST['Error'])) ? strip_tags($_REQUEST['Error']) : null;           //Error Number
        //$ResResult      =   (isset($_REQUEST['result']))    ? strip_tags($_REQUEST['result']) : null;           //Transaction Result
        $ResPosdate = (isset($_REQUEST['postdate'])) ? strip_tags($_REQUEST['postdate']) : null;         //Postdate
        $ResTranId = (isset($_REQUEST['tranid'])) ? strip_tags($_REQUEST['tranid']) : null;         //Transaction ID
        $ResAuth = (isset($_REQUEST['auth'])) ? strip_tags($_REQUEST['auth']) : null;               //Auth Code
        $ResAVR = (isset($_REQUEST['avr'])) ? strip_tags($_REQUEST['avr']) : null;                //TRANSACTION avr
        $ResRef = (isset($_REQUEST['ref'])) ? strip_tags($_REQUEST['ref']) : null;                //Reference Number also called Seq Number
        $ResAmount = (isset($_REQUEST['amt'])) ? strip_tags($_REQUEST['amt']) : null;             //Transaction Amount
        $Resudf1 = (isset($_REQUEST['udf1'])) ? strip_tags($_REQUEST['udf1']) : null;              //UDF1
        $Resudf2 = (isset($_REQUEST['udf2'])) ? strip_tags($_REQUEST['udf2']) : null;               //UDF2
        $Resudf3 = (isset($_REQUEST['udf3'])) ? strip_tags($_REQUEST['udf3']) : null;                //UDF3
        $Resudf4 = (isset($_REQUEST['udf4'])) ? strip_tags($_REQUEST['udf4']) : null;    //UDF4
        $Resudf5 = (isset($_REQUEST['udf5'])) ? strip_tags($_REQUEST['udf5']) : null;    //UDF5
        if ($ResErrorText == null && $ResErrorNo == null && $ResPaymentId != null) {
            // success
            $ResTranData = (isset($_REQUEST['trandata'])) ? strip_tags($_REQUEST['trandata']) : null;
            $decrytedData = $this->decrypt($ResTranData, $this->resource_key);
            parse_str($decrytedData, $output);

            if ($ResTranData != null) {
                $result['status'] = 'success';
                $result['paymentid'] = $ResPaymentId;
                $result['trackid'] = $ResTrackID;
                $result['tranid'] = $output['tranid'];
                $result['ref'] = $output['ref'];
                $result['result'] = $output['result'];
                $result['postdate'] = $output['postdate'];
                $result['auth'] = $output['auth'];
                $result['avr'] = $output['avr'];                 //TRANSACTION avr
                $result['ammount'] = $output['amt'];              //Transaction Amount
                $result['udf1'] = $output['udf1'];               //UDF1
                $result['udf2'] = $output['udf2'];               //UDF2
                $result['udf3'] = $output['udf3'];               //UDF3
                $result['udf4'] = $output['udf4'];               //UDF4
                $result['udf5'] = $output['udf5'];
                //Decryption logice starts
                $result['data'] = $decrytedData;
                $result['ErrorText'] = $ResErrorText;        //Error
                $result['Error'] = $ResErrorNo;
            } else {
                $result['status'] = 'error';
                $result['paymentid'] = $ResPaymentId;
                $result['trackid'] = $ResTrackID;
                $result['tranid'] = $ResTranId;
                $result['ref'] = $ResRef;
                $result['result'] = 'error';
                $result['data'] = strip_tags(http_build_query($_REQUEST));
                $result['postdate'] = $ResPosdate;
                $result['auth'] = $ResAuth;
                $result['avr'] = $ResAVR;                 //TRANSACTION avr
                $result['ammount'] = $ResAmount;              //Transaction Amount
                $result['udf1'] = $Resudf1 ?? @WC()->session->get('alnazer_knet_payment_order_id');             //UDF1
                $result['udf2'] = $Resudf2;               //UDF2
                $result['udf3'] = $Resudf3;               //UDF3
                $result['udf4'] = $Resudf4;               //UDF4
                $result['udf5'] = $Resudf5;
                $result['ErrorText'] = $ResErrorText;        //Error
                $result['Error'] = $ResErrorNo;
            }

        } else {
            // error
            $result['status'] = 'error';
            $result['paymentid'] = $ResPaymentId;
            $result['trackid'] = $ResTrackID;
            $result['tranid'] = $ResTranId;
            $result['ref'] = $ResRef;
            $result['result'] = 'error';
            $result['data'] = strip_tags(http_build_query($_REQUEST));
            $result['ErrorText'] = $ResErrorText;        //Error
            $result['Error'] = $ResErrorNo;           //Error Number
            $result['postdate'] = $ResPosdate;        //Postdate
            $result['auth'] = $ResAuth;               //Auth Code
            $result['avr'] = $ResAVR;                 //TRANSACTION avr
            $result['ammount'] = $ResAmount;              //Transaction Amount
            $result['udf1'] = $Resudf1 ?? @WC()->session->get('alnazer_knet_payment_order_id');                 //UDF1
            $result['udf2'] = $Resudf2;               //UDF2
            $result['udf3'] = $Resudf3;               //UDF3
            $result['udf4'] = $Resudf4;               //UDF4
            $result['udf5'] = $Resudf5;
        }

        return $result;
    }
}
