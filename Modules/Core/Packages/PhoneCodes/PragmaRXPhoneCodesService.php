<?php
namespace Modules\Core\Packages\PhoneCodes;
use Cache;
use PragmaRX\Countries\Package\Countries;

class PragmaRXPhoneCodesService implements PhoneCodesManager
{
    public function supportedPhoneCodes()
    {
        return Cache::rememberForever("supportedPhoneCodes", function () {
            $supportedPhoneCodes = [];
            foreach (Countries::all() as $key => $value) {
                if (isset($value->dialling) && isset($value->dialling->calling_code)) {
                    $country['name']          = $value->name->common;
                    $country['code']          = $value->cca2;
                    $country['flag']          = optional($value->flag)->emoji;
                    $country['calling_code']  = optional(optional($value)->dialling)->calling_code;

                    $supportedPhoneCodes[] = $country;
                }
            }
            return $supportedPhoneCodes;
        });
    }
}
