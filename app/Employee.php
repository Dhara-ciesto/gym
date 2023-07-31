<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model

{
	protected $table = 'employee';
   protected $primaryKey = 'employeeid';
   protected $fillable = [
         'roleid','username','first_name','last_name','role','email','address','city','department','salary','workinghourfrom1','workinghourto1','workinghourfrom2','workinghourto2','dob','gender','mobileno','password', 'photo','accountno','accountname','ifsccode','bankname','branchname','branchcode','status','userid','files','fitpin','workinghour'];

  public function Role()
  {
    return $this->belongsTo('App\Role', 'roleid');
  }
  
  public function deviceuser(){

		return $this->hasOne('App\Device_Employee', 'employeeid', 'employeeid');

	}
}
