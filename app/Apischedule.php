<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apischedule extends Model
{
    protected $table = 'apischedule';
	  protected $primaryKey = 'apischeduleid'; 
     protected $fillable = [
       'apiset','startdate','status'];
}
