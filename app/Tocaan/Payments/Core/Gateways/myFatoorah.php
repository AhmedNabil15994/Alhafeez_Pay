<?php
namespace App\Tocaan\Payments\Core\Gateways;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Tocaan\Payments\Core\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Tocaan\Payments\Models\Invoice;
use App\Tocaan\Payments\Core\LoadDriver;
use App\Tocaan\Payments\Core\PaymentsBase;
use App\Tocaan\Payments\Core\PaymentsActions;
use App\Tocaan\Payments\Core\Contracts\GatewayContract;

class myFatoorah extends PaymentsActions implements GatewayContract
{
    const DRIVER = 'myfatoorah';
    private array $driver;
    private $fields;
    private $invoice;
    protected array $supplier;

    public function __construct()
    {
        $this->driver = (new LoadDriver( self::DRIVER ))->resolve();
        $this->client = new Client;
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

        $response = $this->client->url(config('payments.sandbox') ? $this->driver['sandbox_url'] : $this->driver['live_url'] )
        ->auth($this->driver['auth'], $credentials ?? $this->driver['credentials']);

        switch ( Str::upper($this->driver['request_method']) )
        {
            case 'POST': $response->post($this->fields()); break;
            case 'PUT': $response->put($this->fields()); break;
            default: $response->get($this->fields()); break;
        }

        $result = $response->connect();

        if( $result->ok() )
        {
            if( !is_null($result->body()) )
            {
                $body = json_decode($result->body());

                if( !is_null($body->IsSuccess) && $body->IsSuccess==true && !is_null($body->Data->InvoiceURL) )
                {
                    return redirect()->to($body->Data->InvoiceURL);
                }
            }
        }

        return null;
    }

    protected function supplier(array $data)
    {
        $this->supplier = $data;
        return $this;
    }

    protected function fields()
    {
        $fields = [
            'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
            'InvoiceValue'       => $this->total ?? $this->invoice->total,
            'CustomerName'       => $this->client_name ?? $this->invoice->user->name,
            //Fill optional data
            'DisplayCurrencyIso' => $this->currency ?? 'KWD',
            //'MobileCountryCode'  => '+965',
            'CustomerMobile'     => $this->client_mobile ?? $this->invoice->user->mobile,
            'CustomerEmail'      => $this->client_email ?? $this->invoice->user->email,
            'CallBackUrl'        => $this->success_url ?? route('payments.callback',
            [
                'transaction_number' => $this->invoice->activeTransaction->number,
                'driver' => base64_encode(self::DRIVER)
            ]),
            'ErrorUrl'           => $this->error_url ?? route('payments.failure',
            [
                'transaction_number' => $this->invoice->activeTransaction->number,
                'driver' => base64_encode(self::DRIVER)
            ]),
            'Language'           => app()->getLocale(),
            'CustomerReference'  => $this->order_id ?? $this->invoice->number,
            //'CustomerCivilId'    => 'CivilId',
            //'UserDefinedField'   => 'This could be string, number, or array',
            //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
            'SourceInfo'         => 'Payments Lib Based On Laravel',
            //'CustomerAddress'    => $customerAddress,
            'InvoiceItems'       => ['ItemName' => $this->product_title ?? $this->invoice->description],
            'Suppliers'              => $this->supplier ?? null
        ];

        return $fields;
    }
}
