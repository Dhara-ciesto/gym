<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HR_Loan extends Model
{
    protected $table = 'hr_loan';
    protected $primaryKey = 'hr_loan_id';

    public function employeename(){

        return $this->hasOne('App\Employee', 'employeeid', 'employeeid');

    }
}
