<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class Concept extends JsonResource
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
            'concept_name' => $this->concept_name,
            'metadata' => $this->metadata,
        ];
    }
}
