<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smssetting extends Model
{
     protected $table = 'smssetting';
   
   protected $fillable = [

        'authenticationkey','balance','oldpassword','currentpassword',
    ];
}
