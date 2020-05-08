<?php

namespace App\Model;

class Metadata extends BaseModel
{
    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }
}
