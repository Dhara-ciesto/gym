<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passwordsettings extends Model
{
   protected $table = 'passwordsettings';
      protected $primaryKey = 'passwordsettingsid';
   protected $fillable = [
   	'excelpassword','pdfpassword','status' ];
}
