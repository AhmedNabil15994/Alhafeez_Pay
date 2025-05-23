<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileCode extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    /**
     * Get the parent user model .
     */
    public function user()
    {
        return $this->morphTo();
    }
}
