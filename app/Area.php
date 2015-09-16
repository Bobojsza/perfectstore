<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('area','id')->all();
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }
}
