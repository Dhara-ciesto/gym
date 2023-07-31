<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberDiet extends Model
{
	protected $table = 'memberdiet';
     protected $primaryKey = 'memberdietid';
   protected $fillable = [
   	
        'memberid','plannameid','status','mealid','dietday','diettime','dietitemid','notesid','tagsid','compulsary','dietsequence','remark','fromdate','todate'];
		 public function DietPlanname(){

	 return $this->belongsTo('App\DietPlanname','plannameid');	
	}
	 public function MealMaster(){

	 return $this->belongsTo('App\MealMaster','mealid');	
	}
	 public function MemberDietPlan(){

	 return $this->belongsTo('App\MemberDietPlan','plannameid');	
	}
	// function DietItem() {
 //    return $this->belongsToMany('App\DietItem')->wherePivotIn('dietitemid');
	// 	}
		
					
}
