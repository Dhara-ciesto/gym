<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HR_device_emplog extends Model
{
    protected $table = 'hr_device_emplog';
     protected $primaryKey = 'hr_device_emplogid';
     protected $fillable = [
        'dateid','empid','timein1','timeout1','timein2','timeout2','timein3','timeout3','type','leave','totalworkinghours','salary','status'
];
public function empname(){

    return $this->hasOne('App\Employee', 'employeeid', 'empid');
}
}
