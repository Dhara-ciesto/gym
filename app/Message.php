<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'messagesid';

    protected $fillable = [
   		'subject','message', 'type','sms','email'
    ];

    protected $created_at = 'false';
    protected $updated_at = 'false';
}
