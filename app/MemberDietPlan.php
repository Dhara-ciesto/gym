<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberDietPlan extends Model
{

    protected $table = 'memberdietplan';
     protected $primaryKey = 'memberdietplanid';
   protected $fillable = [
      'mealid','dietday',	
      'diettime'	,
      'dietitemid'	,
      'notesid'	,
      'tagsid'	,
      'compulsary'	,
      'remark'	,
      'dietsequence'	,
      'status'	,
      'fromdate',	
      'todate',
        'memberid','plannameid','status','fromdate','todate','created_at','updated_at'];

  	 public function DietPlanname(){

	 return $this->belongsTo('App\DietPlanname','plannameid');	
	}			
}
