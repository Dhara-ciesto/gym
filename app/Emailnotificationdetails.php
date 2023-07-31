<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailnotificationdetails extends Model
{
    protected $table = 'emailnotificationdetails';
   
   protected $fillable = [

        'emailform','mobileno','emailto','subject','message','user_id'
    ];

}
