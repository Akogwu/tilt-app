<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'transaction_id'=> $this->transaction_id,
            'payment_by'=> $this->getUser($this->payment_by),
            'payment_type'=> $this->payment_type,
            'amount'=> $this->amount,
            'payment_for'=> $this->getPaymentFor($this->payment_type, $this->payment_for),
            'quantity'=> $this->quantity,
            'created'=>$this->created_at
        ];
    }
}
