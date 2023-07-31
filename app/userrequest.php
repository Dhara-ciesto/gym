<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userrequest extends Model
{
      protected $table = 'userrequest';
      protected $primaryKey = 'userrequestid';
   protected $fillable = [
   	'mobileno','requestsub','requestdetail','status',
     ];
 }
