<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealMaster extends Model
{
  protected $table = 'mealmaster';
      protected $primaryKey = 'mealmasterid';
   protected $fillable = [
   		'mealname','status','extra2','extra3',
     ];

	public function MemberDiet(){
	 return $this->belongsTo('App\MemberDiet','mealmasterid');	
	}

	
}
