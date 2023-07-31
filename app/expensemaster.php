<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expensemaster extends Model
{
    protected $table = 'expensemaster';
      protected $primaryKey = 'expensecategoryid';
   protected $fillable = [
   	'categoryname','status','extra2','extra3','updated_at','deleted_at'
     ];
}
