<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MetadataDictionary extends Model
{
    protected $fillable = ['description', 'type', 'start_date', 'end_date'];
}
