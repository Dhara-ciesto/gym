<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailsetting extends Model
{
   protected $table = 'emailsetting';
   
   protected $fillable = [

        'hearder','senderemailid','himage','fimage',
    ];
}
