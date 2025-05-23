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

class uPayments extends PaymentsActions implements GatewayContract
{
    const DRIVER = 'upayments';
    private array $driver;
    private $fields;
    private $invoice;
    protected array $ExtraMerchantsData;

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
                if( !is_null($body->status) && $body->status=='success' && !is_null($body->paymentURL) )
                {
                    return redirect()->to($body->paymentURL);
                }
            }
        }

        return null;
    }

    protected function ExtraMerchantsData(array $data)
    {
        $this->ExtraMerchantsData = $data;
        return $this;
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
            'CstFName' => $this->client_name ?? $this->invoice->user->name,
            'CstEmail' => $this->client_email ?? $this->invoice->user->email,
            'CstMobile' => $this->client_mobile ?? $this->invoice->user->mobile,
            'ProductTitle' => $this->product_title ?? $this->invoice->description,
        ];

        //Extra Merchant Data for Multi Merchant
        if( isset($this->ExtraMerchantsData) && is_array($this->ExtraMerchantsData) && !is_null($this->ExtraMerchantsData) && count($this->ExtraMerchantsData) > 0 )
        {
            $fields = array_merge($this->ExtraMerchantsData, $fields);
        }

        return $fields;
    }
}
