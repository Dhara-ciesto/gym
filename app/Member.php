<?php

namespace App;
use App\ExerciseProgram;
use Illuminate\Database\Eloquent\Model;


class Member extends Model
{

	    // use Sortable;
 protected $table = 'member';
     protected $primaryKey = 'memberid';
   protected $fillable = [
        'memberid','userid','firstname','lastname','address','city', 'gender',	'email','bloodgroup',	'createddate','hearabout','other','formno','mobileno',	'homephonenumber',	'officephonenumber','profession','birthday','anniversary','emergancyname','emergancyrelation','emergancyaddress','emergancyphonenumber','workinghourfrom','workinghourto','	amount','companyid','photo','memberpin','extra1','extra2','status','refno',];
        public $sortable = ['memberid', 'firstname', 'mobileno', 'created_at', 'updated_at'];

//  public function ExerciseProgram()
// {
//   return $this->HasMany('App\ExerciseProgram','MemberId');
// }
// public function Fitnessgoals()
// {
//   return $this->belongsTo('App\Fitnessgoals', 'MemberId');
// }
public function ExerciseProgram()
{
   return $this->hasOne('App\ExerciseProgram','memberid');
}
public function Company()
{
   return $this->hasOne('App\Company','companyid');
}
public function Fitnessgoals()
{
   return $this->hasOne('App\Fitnessgoals','memberid');
}
public function Payment()
{
   return $this->hasOne('App\Payment','memberid');
}
public function User()
{
   return $this->hasOne('App\User','userid');
}
public function Measurement()
{
   return $this->hasMany('App\Measurement','memberid');
}

}


