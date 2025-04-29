<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SacramentResource extends JsonResource
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
            'reason' => $this->reason,
            'amount' => $this->amount,
            'user' => $this->user ?? null,
            'user_id' => $this->user ? $this->user->id : null,
            'sacramented_at' => $this->sacramented_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
