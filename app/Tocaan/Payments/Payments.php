<?php
namespace App\Tocaan\Payments;

use App\Tocaan\Payments\Models\Invoice;
use App\Tocaan\Payments\Core\PaymentsBase;

class Payments extends PaymentsBase
{
    public function __construct(private Invoice $invoice)
    {
        parent::__construct($invoice);
    }
}
