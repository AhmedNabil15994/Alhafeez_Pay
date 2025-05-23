<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Transformers\Api\CountryResource;
use Modules\Company\Transformers\Api\CompanyResource;
use Modules\Ensaan\Transformers\Api\StudentLevelResource;

class SelimUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'name'          => $this->name,
           'email'         => $this->email ?? "",
           'mobile'        => $this->mobile,
           "nationality"   => new CountryResource($this->whenLoaded("nationality")),
           "level"         => new StudentLevelResource($this->whenLoaded("level")),
           'phone_code'    => $this->phone_code,
           'image'         => url($this->image),
           "id_number"     => $this->id_number,
           "type"          => $this->type,
           'id_image'      => url($this->id_image),
       ];
    }
}
