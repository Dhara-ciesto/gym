<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
	protected $table = 'exercise';
      protected $primaryKey = 'exerciseid';
   protected $fillable = [
   		'exercisename','videoname'
     ];

	 public function member()
	{
	  return $this->belongsTo('App\Member','memberid');
	}
	public function MemberExercise(){
	 return $this->belongsTo('App\MemberExercise','exerciseid');	
	}
}
