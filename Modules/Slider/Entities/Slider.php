<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ClearsResponseCache;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use CrudModel, SoftDeletes,HasTranslations;
    use ClearsResponseCache;

    public $translatable = ['title', "description"];
    protected $guarded = ["id"];
}
