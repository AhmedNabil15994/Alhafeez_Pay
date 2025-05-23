<?php
namespace App\Tocaan\Payments\Core;

use Closure;
use Illuminate\Support\Str;
use App\Tocaan\Payments\Core\Gateway;
use App\Tocaan\Payments\Models\Invoice;
use Illuminate\Support\Facades\Session;
use App\Tocaan\Payments\Core\LoadDriver;
use App\Tocaan\Payments\traits\ErrorsHandler;

class PaymentsBase
{
    use ErrorsHandler;

    private array $drivers;
    private array $driver;
    private null|Gateway $instance;
    public string $driver_session_key;
    private string $instance_session_key;
    private string $driver_key;
    protected array $credentials;

    public function __construct(private Invoice $invoice, $guard="web")
    {
        $this->drivers = config('payments.drivers');
        $this->driver_session_key = 'driver-pay-for-invoice-'.$invoice->number;
        $this->instance_session_key = 'instance-pay-for-invoice-'.$invoice->number;

        $this->guard = $guard;

        Session::put('billable_guard', $this->guard, 60 * 60);
    }

    /**
     * Overwrite the config credentials if you want
     * @var array $credentials
     */
    protected function credentials(array $credentials)
    {
        $this->credentials = $credentials;
        return $this;
    }

    /**
     * Set the payment gateway upayments | myfatoorah | tap
     * @var string $driver
     */
    public function via(string $driver)
    {
        //set the gateway driver (payment method name)
        $this->driver_key = $driver;
        $this->driver = (new LoadDriver( $driver ))->resolve();

        //load gateway instance
        $this->load();

        return $this;
    }

    /**
     * Give me route to make the client land on it after successful payments process
     * @var string $url
     */
    public function SuccessRedirect(string $url)
    {
        Session::put('success_redirect_to', $url, 60 * 60);
        return $this;
    }

    /**
     * Give me route to make the client land on it after failure payments process
     * @var string $url
     */
    public function FailureRedirect(string $url)
    {
        Session::put('failure_redirect_to', $url, 60 * 60);
        return $this;
    }

    /**
     * Storing the previous URL just in case we can not find the success or failure routes
     */
    protected function PrevUrl()
    {
        Session::put('prev_url', str_replace(url('/'), '', url()->previous()), 60 * 60);
    }

    /**
     * Go pay
     */
    public function pay()
    {
        return $this->instance->pay( $this->credentials ?? null );
    }

    /**
     * Successful payments process
     */
    public function success()
    {
        return $this->instance->success();
    }

    /**
     * Failed payments process
     */
    public function failure()
    {
        return $this->instance->failure();
    }

    /**
     * Access to the private property
     */
    public function getInvoice(): null|Invoice
    {
        return $this->invoice;
    }

    /**
     * Retrieve the payment gateway instance for creating payment link, callback check, error response checker
     */
    public function getInstance(): null|Gateway
    {
        //Load gateway instance
        // #option1: from session key
        if( !is_null($instance = Session::get($this->instance_session_key)) )
        {
            return $instance;
        }

        // #option2: manually from driver memory propery
        if( !is_null($this->driver) )
        {
            $this->load();

            return $this->insatnce;
        }

        // #option3: manually from driver session key
        if( !is_null($driver = Session::get($this->driver_session_key)) )
        {
            $this->driver = $driver;
            $this->load();

            return $this->insatnce;
        }

        return null;
    }

    /**
     * Call the gateway class instance
     *
     * @return void
     */
    protected function load(): void
    {
        if( !array_key_exists($this->driver_key, $this->drivers) )
        {
            $this->throw('Payment method not supported! Please choose form this list: ('.implode(' | ', array_keys($this->drivers)).')');
        }

        if( isset($this->driver['namepspace']) )
        {
            $this->instance = new Gateway( $this->driver['namepspace'], $this->invoice );

            Session::put($this->driver_session_key, $this->driver);
            // Session::put($this->instance_session_key, $this->instance);
        } else {
            $this->throw('Something went wrong!');
        }
    }

    /**
     * Build new transaction for the payment process
     *
     * @var string $perfix | the transaction prefix | the default found in the Config: payments.prefix
     * @var integer $length
     * @var null|Invoice $invoice
     *
     * @return void
     * */
    public function buildTransaction($driver, $prefix=null, int $length=16, $invoice=null): void
    {
        if( is_null($invoice) ){ $invoice = $this->invoice; }

        if( is_null($invoice) )
        {
            $this->throw('Can not find invoice, please set the correct invoice to the constructor!');
        }

        if( is_null($prefix) )
        {
            $prefix = config('payments.prefix');
        }

        $number = $prefix . substr( base64_encode(time() . Str::random(20) ) ,0 , $length) .'-'. date('Ymd') . time();

        $invoice->transactions()->updateOrCreate(
            [
                'status' => 'pending',
            ],
            [
                'number' => $number,
                'amount' => $this->invoice->total,
                'paymentmethod_slug' => $driver
            ]
        );
    }
}
