<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deviceusers extends Model
{
    protected $table = 'deviceusers';
     protected $primaryKey = 'deviceusersid';
   protected $fillable = [
   	
        'username','userid','userrefid','pin','rfidcard','expirydate','status',];
}
