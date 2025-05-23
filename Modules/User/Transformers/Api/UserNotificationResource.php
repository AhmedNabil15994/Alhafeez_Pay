<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'title'         => $this->title,
           'description'   => $this->description ?? "",
            "type"         => $this->type,
            "data"         => $this->data ?? [] ,
            "read_at"      => $this->read_at ?? "",
            "created_at"   => $this->created_at->format("d-m-Y H:i a"),
       ];
    }
}
