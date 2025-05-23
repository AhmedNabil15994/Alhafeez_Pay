<?php
namespace Modules\Core\Packages\PhoneCodes;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Packages\PhoneCodes\PhoneCodesManager;

class PhoneCodes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return PhoneCodesManager::class; }
}
