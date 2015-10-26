<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleSelect extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::orderBy('option')
    	->lists('option','id')
    	->all();
    }
}
