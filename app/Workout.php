<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Workout extends Model
{
    protected $table = 'workout';
      protected $primaryKey = 'workoutid';
   protected $fillable = [
   		'workoutname',
     ];

	 public function member()
	{
	  return $this->belongsTo('App\Member','memberid');
	}
	public function MemberExercise(){
	 return $this->belongsTo('App\MemberExercise','workoutid');	
	}
}
