<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTemplate extends Model
{

	protected $fillable = ['template', 'start_date', 'end_date'];
	
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('template','id')->all();
    }
}
