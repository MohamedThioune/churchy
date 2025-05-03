<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestResource extends JsonResource
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
            'amount' => $this->amount,
            'type' => $this->type,
            'location' => $this->location,
            'ceremony' => $this->ceremony,
            'user_ids' => $this->users ? $this->users->pluck('id') : null,
            'users' => $this->users ?? null,
            'quested_at' => $this->quested_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
