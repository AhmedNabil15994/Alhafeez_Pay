<?php

namespace Modules\Invoice\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // $channel = 'N/A';

        // if( !is_null($this->plugin) )
        // {
        //     $channel_exp = explode(":", $this->plugin->channel);
        //     $channel = __('invoice::dashboard.invoices.channels.'.$channel_exp[0]);
        // }

         return [
                    'id' => $this->id,
                    'client_name' => $this->user->name,
                    'client_phone' => $this->user->mobile,
                    'amount' => $this->amount,
                    'reference_no' => !is_null($this->plugin) ? $this->plugin->reference_no : '--',
                    'note' => !is_null($this->plugin) ? $this->plugin->note : '--',
                    'total' => $this->total,
                    // 'channel' => $channel,
                    'payment_status' => !is_null($this->plugin) ? $this->plugin->payment_status : 'failed',
                    'number' => $this->number,
                    'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
                    'deleted_at' => $this->deleted_at
        ];
    }
}
