<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DietPlanname extends Model
{
   protected $table = 'dietplanname';
      protected $primaryKey = 'dietplannameid';
   protected $fillable = [
   	'dietplanname','status',
     ];
      public function member()
	{
	  return $this->belongsTo('App\Member','memberid');
	}
	public function MemberDietPlan(){
	 return $this->belongsTo('App\MemberDietPlan','dietplannameid','dietplannameid');	
	}
}
