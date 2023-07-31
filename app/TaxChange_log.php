<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxChange_log extends Model
{
	 protected $table='taxchange_log';
     protected $primaryKey = 'taxchange_logid';
    protected $fillable = [
     'title' ,	'oldtax',	'newtax'	,'update_by'	,'updateon',
    ];
    
}
