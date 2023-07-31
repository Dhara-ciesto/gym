<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRDeviceseqcount extends Model
{
    protected $table = 'hr_deviceseqcount';
    protected $primaryKey = 'deviceseqcountid';
    protected $fillable = [
        'deviceid',
     'rollovercount','seqno',];
    
    
}
