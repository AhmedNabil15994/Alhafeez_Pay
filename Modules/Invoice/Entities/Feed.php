<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;

class Feed extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['feed'];
}
