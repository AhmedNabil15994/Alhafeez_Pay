<?php

namespace Modules\Invoice\Entities;

use Modules\Invoice\Entities\Invoice;
use Modules\User\Entities\CustomToken;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ClearsResponseCache;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentLink extends Model
{
    use CrudModel{
        __construct as private CrudConstruct;
    }
    use ClearsResponseCache;

    use SoftDeletes {
        restore as private restoreB;
    }

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function token()
    {
        return $this->belongsTo(CustomToken::class, 'custom_token_id');
    }

    public function restore()
    {
        $this->restoreB();
    }
}
