<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormCategory extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('category','id')->all();
    }
}
