<?php
namespace Modules\Apps\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
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
             'id'           => $this->id,
             "username"      => $this->username ,
             "email"        => $this->email,
             "mobile"       => $this->mobile,
             "message"      => $this->message,
             "created_at"=> $this->created_at->format("d-m-Y h:i a"),
             'deleted_at'    => $this->deleted_at,
        ];
    }
}
