<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addpt extends Model
{
   protected $table='ptlevel';

    protected $fillable = [
        'level','percentage',
    ];
}

            	