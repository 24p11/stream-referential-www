<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Metadata extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $metadata = $this->content->merge([
            'concept_id' => $this->concept_id,
            'standard_concept' => $this->standard_concept,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
        return $metadata->all();
    }
}
