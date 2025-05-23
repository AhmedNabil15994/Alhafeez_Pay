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

class Moyasar extends PaymentsActions implements GatewayContract
{
    const DRIVER = 'moyasar';
    private array $driver;
    private $fields;
    private $invoice;

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

        if( $result->status()==201 )
        {
            if( !is_null($result->body()) )
            {
                $body = json_decode($result->body());

                if( !is_null($body->status) && $body->status=='initiated' && !is_null($body->url) )
                {
                    return redirect()->to($body->url);
                }
            }
        }

        return null;
    }

    protected function fields()
    {
        $fields =
        [
            'amount' => ceil($this->invoice->total * 1000),
            'currency' => $this->currency ?? 'KWD',
            'description' => $this->invoice->description ?? 'Invoice - '.$this->invoice->number,
            'callback_url' => $this->success_url ?? route('payments.callback',
            [
                'transaction_number' => $this->invoice->activeTransaction->number,
                'driver' => base64_encode(self::DRIVER)
            ])
        ];

        return $fields;
    }
}
