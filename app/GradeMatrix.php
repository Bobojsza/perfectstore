<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeMatrix extends Model
{
	public $timestamps = false;
	
    protected $table = 'grade_matrixs';

    public static function getLists(){
    	return self::lists('desc','id')->all();
    }
}
