<?php

namespace App\Model;


class Concept extends BaseModel
{
    //
    protected $table = 'concept';

    public function metadata()
    {
        return $this->hasMany('App\Metadata');
    }
}
