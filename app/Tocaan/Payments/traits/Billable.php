<?php
namespace App\Tocaan\Payments\traits;

use App\Tocaan\Payments\Models\Invoice;
use App\Tocaan\Payments\Models\Transaction;

trait Billable
{
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'model_id');
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Invoice::class);
    }
}
