<?php
namespace Modules\User\Enum;

class UserType extends \SplEnum
{
    const USER  = "user";
    const ADMIN = "admin";
    const PARENTS="parent";
    const CIVIL="civil";


    public static function getTypeRegisterApi()
    {
        return [self::USER, self::PARENTS, self::CIVIL];
    }
}
