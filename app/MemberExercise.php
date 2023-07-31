<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberExercise extends Model
{
    protected $table = 'memberexercise';
		     protected $primaryKey = 'memberexerciseid';
		   protected $fillable = [
		        'memberid','packageid','header','workoutid','exerciselevel','exerciseday','assignday','exerciseid','memberexercisetime','memberexerciseset','memberexerciserep','memberexerciseins','status','assignedby'];


 public function Workout(){
	 return $this->belongsTo('App\Workout','workoutid');
	}
	 public function Exercise(){
	 return $this->belongsTo('App\Exercise','exerciseid');
	}
}
