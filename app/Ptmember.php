<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ptmember extends Model
{
    protected $table='ptmember';
    protected $primaryKey = 'ptmemberid';
    protected $fillable = [
       'ptmemberid',	'trainerid'	,'memberid',	'day'	,'date'	,'fromdate',	'todate',	'hoursfrom',	'hoursto',	'actualdate',	'actualtime',	'status',	'finaltrainerid',	'packageid','schemeid',	'commision',	'persessioncommision',	'persessionamount',	'paymentstatus',	'conducteddate'	,'conductedtime',
    ];
}
