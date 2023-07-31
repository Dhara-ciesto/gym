<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_log extends Model
{
   protected $table = 'user_log';
      protected $primaryKey = 'log_id';
   protected $fillable = [
   		'UserId',	'register_id',	'PunchDateTime',	'SerialNumber',	'created_at','updated_at','action_by'

     ];
}
