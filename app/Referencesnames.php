<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referencesnames extends Model
{
    protected $fillable = ['fk_reference_id', 'fk_language_code', 'text'];
}
