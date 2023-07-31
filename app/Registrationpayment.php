<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registrationpayment extends Model
{
    protected $table = 'registrationpayment';
   	     protected $primaryKey = 'registrationpaymentid';
   protected $fillable = [
        'payment','status',];

}
