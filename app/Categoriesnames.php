<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoriesnames extends Model
{
    protected $fillable = ['fk_category_id', 'fk_language_code', 'text'];
}
