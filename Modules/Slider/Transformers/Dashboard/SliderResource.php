<?php

namespace Modules\Slider\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"           => $this->id ,
            "title"        => $this->title ?? "",
            "description"  => $this->description ?? "",
            "image"        => url($this->image),
            "type"         => $this->type ,
            "value"        => $this->value ?? "" ,
            "status"       => $this->status ,
            "created_at"    => $this->created_at->format("d-m-Y h:i a"),
            'deleted_at'    => $this->deleted_at,
        ];
    }
}
