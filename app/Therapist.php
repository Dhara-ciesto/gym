<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $table = 'therapist';
   	     protected $primaryKey = 'therapistid';
   protected $fillable = [
        'name','mobileno','status',];

}
