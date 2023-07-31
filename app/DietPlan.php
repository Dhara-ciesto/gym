<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{
    protected $table = 'dietplan';
      protected $primaryKey = 'dietplanid';
   protected $fillable = [
   		'dietplannameid','mealid','dietday','diettime',	'dietitemid',	'notesid'	,'tagsid','compulsary','remark','dietsequence','status',
     ];
}
