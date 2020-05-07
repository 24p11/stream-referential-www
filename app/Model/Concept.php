<?php

namespace App\Model;


class Concept extends BaseModel
{
    protected $table = 'concept';

    public function metadata()
    {
        return $this->hasMany(Metadata::class, 'concept_id', 'vocabulary_id_concept_code');
    }
}
