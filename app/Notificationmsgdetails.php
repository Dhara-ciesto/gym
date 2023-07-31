<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificationmsgdetails extends Model
{
    protected $table = 'notoficationmsgdetails';
    protected $primaryKey = 'notoficationmsgdetailsid';
   protected $fillable = [
        'mobileno','smsmsg','mailmsg','callnotes'];
}
