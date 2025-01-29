<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResources extends JsonResource
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
            'access' => $this->access->accessText,
            'description' => $this->description,
            'files' => FilesResources::collection($this->files),
            'edit_link' => route('frontend.dashboard.freelancer.edit.courses', $this->id),
            'delete_link' => route('frontend.dashboard.courses.destroy', $this->id)
        ];
    }
}
