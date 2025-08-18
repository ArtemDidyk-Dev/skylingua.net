<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'type' => $this->type,
            'promo' => $this->promo,
            'link' => route('frontend.dashboard.courses.deleteFile', [$this->course_id, $this->id]),
        ];
    }
}
