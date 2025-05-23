<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Transformers\Api\CountryResource;
use Modules\Company\Transformers\Api\CompanyResource;
use Modules\Ensaan\Transformers\Api\StudentLevelResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'name'          => $this->name,
           "birth_date"    => $this->birth_date ?? "",
           'email'         => $this->email ?? "",
           'mobile'        => $this->mobile,
           "nationality"   => new CountryResource($this->whenLoaded("nationality")),
           "level"         => new StudentLevelResource($this->whenLoaded("level")),
           'phone_code'    => $this->phone_code,
           'image'         => url($this->image),
           "id_number"     => $this->id_number,
           "type"          => $this->type,
           "admin_approved"=> $this->admin_approved,
           "is_verified"  => (int)$this->is_verified,
           'id_image'      => url($this->id_image),
           "unread_notifications_count"=> $this->when(!is_null($this->unread_user_notifications_count), $this->unread_user_notifications_count)
       ];
    }
}
