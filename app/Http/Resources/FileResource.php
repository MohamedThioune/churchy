<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    
        $key = Storage::disk('s3')->url($this->path . $this->id);
        $temporaryUrl = Storage::disk('s3')->temporaryUrl(
            $this->path . $this->id,
            now()->addHours(2) 
        );
        return [
            'id' => $this->id,
            'type' => $this->type,
            'path' => $this->path,
            'key' => $key,
            'temporary_url' => $temporaryUrl,
            'meaning' => $this->meaning,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
