<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'hr_salary';
    protected $primaryKey = 'salaryid';

    public function employee(){

    	return $this->hasOne('App\Employee', 'employeeid', 'employeeid');

    }

}
