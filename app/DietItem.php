<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DietItem extends Model
{

	protected $table = 'dietitems';
      protected $primaryKey = 'dietitemid';
   protected $fillable = [
   	'dietitem','status','extra1','extra2',
     ];

     

  
}
