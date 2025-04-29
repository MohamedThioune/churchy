<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'reference' => 'BV-' . str_pad($this->id, 5, '0', STR_PAD_LEFT),
            'reason' => $this->reason,
            'type' => $this->type,
            'amount' => $this->amount,
            'authorizer' => $this->authorizer,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
