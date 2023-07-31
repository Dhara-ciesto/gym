<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssignedBelt extends Model
{
   protected $table='userassignedbelt';
	      protected $primaryKey = 'userassignedbeltid';
   protected $fillable = [
        	'userbeltno',	'userrfidno'	,'userid',	'assigneddate',	'returndate',	'userbeltstatus','lastassignuserid'
    ];
}
