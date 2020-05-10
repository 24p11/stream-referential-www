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
            'standard_concept' => $this->standard_concept,
            'metadata_type' => $this->metadata_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
        return $metadata->all();
    }
}
