<?php
namespace App\Tocaan\Payments\Core;

use App\Tocaan\Payments\traits\ErrorsHandler;

class LoadDriver
{
    use ErrorsHandler;

    private $drivers;

    /**
     * Constructor...
     * Loading drive (Payment gateway) from the config fil using the provided key from the PaymentBase->via
     * @var string $driver (The key of the config array)
     */
    public function __construct(private string $driver)
    {
        $this->drivers = config('payments.drivers');
        $this->driver = $driver;

        if( !array_key_exists($this->driver, $this->drivers) )
        {
            $this->throw('Payment method not supported! Please choose form this list: ('.implode(' | ', array_keys($this->drivers)).')');
        }
    }

    /**
     * Retrieving the driver data...
     */
    public function resolve()
    {
        return $this->drivers[$this->driver];
    }
}
