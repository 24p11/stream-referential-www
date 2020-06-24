<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ListDictionary extends Model
{
    protected $fillable = ['description', 'start_date', 'end_date'];
}
