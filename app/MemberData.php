<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberData extends Model
{
    protected $table = 'memberdata';
     protected $primaryKey = 'memberid';
   protected $fillable = [
        'memberid','userid','firstname','lastname','username','address','city', 'gender',	'email','bloodgroup','createddate','hearabout','other','formno','mobileno',	'homephonenumber',	'officephonenumber','profession','birthday','anniversary','emergancyname','emergancyrelation','emergancyaddress','emergancyphonenumber','workinghourfrom','workinghourto','	amount','companyid','photo','files','memberpin','extra1','extra2','status','answer'];
    }
