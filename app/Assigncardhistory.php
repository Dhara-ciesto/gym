<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assigncardhistory extends Model
{
    protected $table = 'assigncardhistory';
	 protected $primaryKey = 'assigncardhistoryid';
   
   protected $fillable = [
        'action','userid'];
}
