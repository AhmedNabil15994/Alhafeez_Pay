<?php

namespace Modules\Invoice\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentLinkResource extends JsonResource
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
                    'id' => $this->id,
                    'invoice_number' => $this->invoice->number,
                    'original_link' => $this->original_link,
                    'short_link' => $this->short_link,
                    'status' => $this->status,
                    'expires_at' => \Carbon\Carbon::parse($this->token->expires_at)->format('Y-m-d'),
                    'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
                    'deleted_at' => $this->deleted_at
        ];
    }
}
