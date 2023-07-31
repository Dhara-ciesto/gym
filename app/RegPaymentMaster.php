<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegPaymentMaster extends Model
{
	 protected $table='regpaymentmaster';
	      protected $primaryKey = 'regpaymentid';
   protected $fillable = [
        'regpaymentname','amount','companyname',	'copersonname',	'contactno',	'gstno','extra','status',
    ];
 

}
