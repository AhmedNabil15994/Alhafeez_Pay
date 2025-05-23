<?php
namespace App\Helpers;

use Modules\Vendor\Entities\Vendor;

class Parents
{
    public static function ParentOrChild(Vendor $vendor)
    {
        if( !is_null($parent_id = $vendor->parent_id) )
        {
            $parent = Vendor::findOrFail( $parent_id );

            return $parent;
        }

        return $vendor;
    }
}
