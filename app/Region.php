<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::orderBy('region')->lists('region','id')->all();
    }
}
