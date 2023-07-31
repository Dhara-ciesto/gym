<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveEntry extends Model
{
    protected $table = 'leaveentry';
    protected $primaryKey = 'leaveentryid';

    public function empname(){

    	return $this->hasOne('App\Employee', 'employeeid', 'employeeid');
    }
}
