<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claimptsession extends Model
{
   
   protected $table = 'claimptsession';
	  protected $primaryKey = 'claimptsessionid'; 
     protected $fillable = [
        'trainerid','actualtrainerid','memberid', 'packageid','scheduledate','scheduletime', 'packageid','actualtime','actualdate','comission','amount','status','dutyhours'];

	 

}
