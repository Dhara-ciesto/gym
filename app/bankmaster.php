<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bankmaster extends Model
{
      protected $table = 'bankmaster';
      protected $primaryKey = 'bankid';
   protected $fillable = [
   	'accountno','accountname','ifsccode','bankname','branchname','branchcode','status',
     ];
 }
