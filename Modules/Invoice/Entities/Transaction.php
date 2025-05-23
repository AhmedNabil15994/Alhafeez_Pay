<?php
namespace Modules\Invoice\Entities;

use Modules\User\Entities\User;
use App\Tocaan\Payments\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ClearsResponseCache;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Tocaan\Subscriptions\Models\Subscription;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use CrudModel{
        __construct as private CrudConstruct;
    }
    use ClearsResponseCache;

    use SoftDeletes {
        restore as private restoreB;
    }

    protected $table = 'transactions';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function restore()
    {
        $this->restoreB();
    }
}
