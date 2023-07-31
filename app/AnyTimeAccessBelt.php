<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnyTimeAccessBelt extends Model
{
	protected $table = 'anytimeaccessbelt';
	  protected $primaryKey = 'anytimeaccessbeltid'; 
     protected $fillable = [
       'beltno','validity','rfidcardno1', 'beltstatus', 'extra','deviceid','username','pin','enrollstatus'];

	 
}
