<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pointsnames extends Model
{
    protected $fillable = ['fk_point_id', 'fk_language_code', 'title', 'description', 'linkalias'];
}
