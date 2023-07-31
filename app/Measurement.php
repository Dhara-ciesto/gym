<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
   protected $table = 'measurement';
     protected $primaryKey = 'measurementid';
   protected $fillable = [
        'memberid','todaydate','weight','height','neck','leftupperarm', 'rightupperarm','chest','waist','hips','leftthigh','rightthigh','leftcalf','rightcalf',];

  public function Member()
{
   return $this->belongsTo('App\Member','memberid');
}		
}
		
										
