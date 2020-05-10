<?php

namespace App\Model;

class Metadata extends BaseModel
{
    protected $casts = [
        'content' => 'collection'
    ];

    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }
}
