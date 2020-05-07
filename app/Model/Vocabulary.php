<?php

namespace App\Model;

class Vocabulary extends BaseModel
{
    protected $keyType = 'string';

    public function vocabulary()
    {
        return $this->hasMany(Concept::class);
    }
}
