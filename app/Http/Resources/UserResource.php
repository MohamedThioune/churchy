<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FileResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'avatar' => new FileResource($this->files->where('meaning', 'Avatar')->sortByDesc('created_at')->first()),
            // 'birthday' => $this->birthday,
            // 'password' => $this->password,
            'address' => $this->address, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
