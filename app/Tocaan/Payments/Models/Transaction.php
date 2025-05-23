<?php
namespace App\Tocaan\Payments\Models;

use App\Models\User;
use Modules\Vendor\Entities\Vendor;
use App\Tocaan\Payments\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Tocaan\Subscriptions\Models\Subscription;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use SoftDeletes {
        restore as private restoreB;
    }

    protected $table = 'transactions';
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::updated(function (Transaction $tr)
        {
            if( $tr->isDirty('status') && $tr->status=="complete" )
            {

            }
        });
    }

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

    public function scopeWithDeleted($query)
    {
        return $query->withTrashed();
    }
}
