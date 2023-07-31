<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workouttag extends Model
{
     protected $table = 'workouttags';
      protected $primaryKey = 'workouttagid';
   protected $fillable = [
   		'workoutid','tagid','extra',	
     ];

	 public function member()
	{
	  return $this->belongsTo('App\Member','memberid');
	}
}
