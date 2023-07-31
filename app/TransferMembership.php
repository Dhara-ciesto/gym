<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferMembership extends Model
{	
	 protected $table='transfermembership';
     protected $primaryKey = 'transfermembershipid';
    protected $fillable = [
       'fromuserid'	,'touserid',	'schemeid',	'transfer_by',	'transfer_on',	'status',	
    ];
    public function transfer(){

    	return $this->hasOne('App\MemberPackages', 'transferid');
    }
    
}
