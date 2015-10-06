<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormCategory extends Model
{
	protected $fillable = ['category'];
	
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('category','id')->all();
    }
}
