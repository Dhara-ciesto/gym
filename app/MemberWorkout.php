<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberWorkout extends Model
{
   protected $table = 'memberworkout';
		     protected $primaryKey = 'memberworkoutid';
		   protected $fillable = [
		        	'memberid','workoutid','extra','status',];
		        	public function Workout(){
	 return $this->belongsTo('App\Workout','workoutid');	
	}
}
