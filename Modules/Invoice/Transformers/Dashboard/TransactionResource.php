<?php

namespace Modules\Invoice\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
                    'client_name' => $this->invoice->user->name ?? 'N/A',
                    'client_phone' => $this->invoice->user->mobile ?? 'N/A',
                    'transaction_key' => $this->number,
                    'ref_id' => $this->ref_id,
                    'amount' => $this->amount,
                    'status' => $this->status,
                    'invoice_amount' => $this->invoice->amount,
                    'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d'),
                    'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
                    'deleted_at' => $this->deleted_at
        ];
    }
}
