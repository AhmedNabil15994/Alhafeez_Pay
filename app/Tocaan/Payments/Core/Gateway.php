<?php
namespace App\Tocaan\Payments\Core;

use App\Tocaan\Payments\Models\Invoice;

class Gateway
{
    private $instance;

    /**
     * Constructor..
     * @var string $namespace of the driver
     * @var \App\Tocaan\Payments\Models\Invoice $invoice
     */
    public function __construct(private string $namespace, private Invoice $invoice)
    {
        if( class_exists($this->namespace) )
        {
            $this->instance = new $this->namespace;
            $this->instance->setInvoice($this->invoice);
        }
    }

    /**
     * Do Payments method...
     * @var null|array $credentials if you wish to provide the credentials via database for example,
     * by default the driver itself provide the Gateway class by its credentials via config file
     */
    public function pay(null|array $credentials)
    {
        return $this->instance->pay( $credentials );
    }

    /**
     * For success response
     */
    public function success()
    {
        return $this->instance->success( request() );
    }

    /**
     * For failed response
     */
    public function failure()
    {
        return $this->instance->failure( request() );
    }
}
