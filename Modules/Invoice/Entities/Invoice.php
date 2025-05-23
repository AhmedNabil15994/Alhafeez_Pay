<?php

namespace Modules\Invoice\Entities;

use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Modules\Invoice\Entities\PaymentLink;
use Modules\Invoice\Entities\InvoicePlugin;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\ClearsResponseCache;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Transaction\Entities\Transaction;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Invoice extends Model implements HasMedia
{
    use CrudModel{
        __construct as private CrudConstruct;
    }
    use ClearsResponseCache, InteractsWithMedia;

    use SoftDeletes {
        restore as private restoreB;
    }

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    public function restore()
    {
        $this->restoreB();
    }

    public function plugin()
    {
        return $this->hasOne(InvoicePlugin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeTransaction() :Attribute
    {
        return new Attribute(
            get: fn () => $this->transactions()->whereStatus('pending')->orderBy('id', 'desc')->first(),
        );
    }

    public function getLastNotPendingTransactionAttribute()
    {
        return $this->transactions()->where('status', '!=', 'pending')->orderBy('id', 'desc')->first();
    }

    public function link()
    {
        return $this->hasOne(PaymentLink::class);
    }

}
