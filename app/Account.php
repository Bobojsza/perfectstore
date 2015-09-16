<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
   	public $timestamps = false;

   	public static function getLists(){
    	return self::lists('account','id')->all();
    }

}
