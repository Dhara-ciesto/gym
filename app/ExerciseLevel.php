<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseLevel extends Model
{
	protected $table = 'exerciselevel';
      protected $primaryKey = 'exerciselevelid';
   protected $fillable = [
   		'exerciselevel'
     ];

	 public function member()
	{
	  return $this->belongsTo('App\Member','memberid');
	}
}
