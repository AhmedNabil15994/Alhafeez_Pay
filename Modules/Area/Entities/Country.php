<?php

namespace Modules\Area\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ClearsResponseCache;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use CrudModel,SoftDeletes, HasTranslations;
    use ClearsResponseCache;

    protected $fillable = ['status','title', 'slug' , "nationality"];
    public $translatable = ['title', 'slug', "nationality"];

}
