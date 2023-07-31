<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberEnrollment extends Model
{
    protected $table = 'deviceuserenrollment';
     protected $primaryKey = 'deviceuserenrollmentid';
   protected $fillable = [
   	
        'devicename','deviceusersid','serialno','status',];
}
