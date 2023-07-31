<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DietNote extends Model
{
   protected $table = 'dietnotes';
      protected $primaryKey = 'dietnoteid';
   protected $fillable = [
   	'dietnote','status','extra1','extra2',
     ];
}
