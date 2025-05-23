<?php

namespace Modules\Invoice\Entities;

use Modules\Invoice\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;

class InvoicePlugin extends Model
{
    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
