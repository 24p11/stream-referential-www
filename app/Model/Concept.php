<?php

namespace App\Model;


class Concept extends BaseModel
{
    protected $table = 'concept';

    public function metadata()
    {
        return $this->hasMany(Metadata::class, 'concept_id', 'vocabulary_id_concept_code');
    }

    public function conceptRelationships()
    {
        return $this->belongsToMany(Concept::class, 'concept_relationship', 'concept_id', 'concept_relation_id', 'vocabulary_id_concept_code', 'vocabulary_id_concept_code');
    }
}
