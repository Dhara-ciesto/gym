<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $table = 'hr_department';
	protected $primaryKey = 'departmentid';
}
