<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTemplate extends Model
{

	protected $fillable = ['template'];
	
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('template','id')->all();
    }
}
