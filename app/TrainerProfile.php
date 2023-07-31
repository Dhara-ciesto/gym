<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerProfile extends Model
{
     protected $table='trainerprofile';
     protected $primaryKey = 'trainerprofileid';
    protected $fillable = [
      'employeeid',	'leveloftrainer',	'city','exp',	'achievments',	'freeslots',	'photo',	'results',	
    ];
  
}
