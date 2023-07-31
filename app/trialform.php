<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trialform extends Model
{
     protected $table='trialform';
     protected $primaryKey = 'trailformid';
    protected $fillable = [
      'clientname',	'mobileno',	'employeeid','date',	'trial',	'level',	'pt',	'gt',	'remarks','remarks2','status','timing',
    ];
}
