<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageUpgradeModel extends Model
{
    protected $table = 'upgradepackage';
    protected $primaryKey = 'upgradepackageid';

    public function oldscheme(){

    	return $this->hasOne('App\Scheme', 'schemeid', 'oldpackageid');

    }

    public function newscheme(){

    	return $this->hasOne('App\Scheme', 'schemeid', 'newpackageid');
    }

    public function member(){

    	return $this->hasOne('App\Member', 'memberid', 'upgradepackagememberid');
    }

}
