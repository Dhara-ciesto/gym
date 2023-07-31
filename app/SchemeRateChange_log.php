<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchemeRateChange_log extends Model
{
	   protected $table='schemeratechange_log';
    protected $primaryKey = 'schemeratechange_logid';
    protected $fillable = [
        	'schemeid',	'oldbaseprice',	'newbaseprice',	'oldactualprice',	'newactualprice',	'oldtax',	'newtax',	'update_by',	'updateon',	
    ];

}
