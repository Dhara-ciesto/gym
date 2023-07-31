<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExercisePlan extends Model
{
    protected $table = 'exerciseplan';
      protected $primaryKey = 'exerciseplanid';
   protected $fillable = [
   		'workoutid','header','exerciseplanlevel',
           'exerciseplanday','exerciseid','exerciseplantime','exerciseplanins',
           'exerciseplanlevelrep','exerciseplanset',

     ];

	 public function member()
	{
	  return $this->belongsTo('App\Member','memberid');
	}
}
