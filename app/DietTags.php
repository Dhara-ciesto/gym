<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DietTags extends Model
{
	protected $table = 'diettags';
      protected $primaryKey = 'diettagid';
   protected $fillable = [
   	'dietid','tagid','extra1'
     ];
}
