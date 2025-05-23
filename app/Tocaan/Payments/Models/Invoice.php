<?php
namespace App\Tocaan\Payments\Models;

use Modules\User\Entities\User;
use Modules\Vendor\Entities\Vendor;
use Illuminate\Database\Eloquent\Model;
use App\Tocaan\Payments\Models\Transaction;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoices';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'model_id');
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
}
