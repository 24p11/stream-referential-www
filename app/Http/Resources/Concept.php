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
            'id' => $this->id,
            'vocabulary_id' => $this->vocabulary_id,
            'concept_code' => $this->concept_code,
            'concept_name' => $this->concept_name,
            'score' => $this->score,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'metadata' => $this->metadata,
        ];
    }
}
