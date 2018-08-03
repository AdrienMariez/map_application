<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = ['link', 'longitude', 'lattitude', 'image_path', 'fk_reference_id'];
}
