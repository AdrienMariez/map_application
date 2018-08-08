<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = ['link', 'longitude', 'lattitude', 'fk_image_id', 'fk_reference_id'];
}
