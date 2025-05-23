<?php

namespace Modules\User\Transformers\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $vendor_id = auth()->guard('vendor')->id();
        if( !is_null($parent_id = auth()->guard('vendor')->user()->parent_id) )
        {
            $vendor_id = $parent_id;
        }

        $note = $this->notes()->where('owner_id', $vendor_id)->first();

        return [
           'id'            => $this->id,
           'name'          => $this->name,
           'email'         => $this->email  ?? "",
           'id_number'     => $this->id_number  ?? "",
           'nationality'     => $this->nationality  ?? "",
           'city'     => $this->city  ?? "",
           'state'     => $this->state  ?? "",
           'mobile'        => $this->mobile ?? "",
           'note'         => $note->status,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y', strtotime($this->created_at)),
       ];
    }

    public function handleParent()
    {
        $name = "";
        foreach ($this->parents as $key => $parent) {
            if ($key != 0) {
                $name .= ",";
            }
            $name .= $parent->name;
        }
        return $name;
    }
}
