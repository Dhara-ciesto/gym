<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table='accounts';
	      protected $primaryKey = 'id';
   protected $fillable = [
   	'accountNo','accountNAme','IFSCcode','BankName','BranchName','BranchCode',
    ];
    public function User() {
        return $this->HasOne('App\User');
    }
}
