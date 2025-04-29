<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'target' => $this->target,
            'amount' => $this->amount,
            'user' => $this->user ?? null,
            'user_id' => $this->user ? $this->user->id : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
