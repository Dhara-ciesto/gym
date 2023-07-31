<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class questionmaster extends Model
{
      protected $table = 'questionmaster';
      protected $primaryKey = 'questionmasterid';
   protected $fillable = [
   	'qustionname','extra','status'
     ];
 }
