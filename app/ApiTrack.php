<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiTrack extends Model
{
    protected $table = 'apitrack';
    protected $primaryKey = 'apitrackid';
    protected $fillable = [
        'userid','apitype','api', 'apiresponse','apistatus'];
}
