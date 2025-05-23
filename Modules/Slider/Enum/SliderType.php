<?php
namespace Modules\Slider\Enum;

class SliderType extends \SplEnum
{
    const NORMAL  = "normal";
    const URL = "url";
    // const CIRCLE="circle";
    
    public static function selectData()
    {
        return  [
            self::NORMAL => "Normal",
            self::URL    => "Url",
        ];
    }
}
