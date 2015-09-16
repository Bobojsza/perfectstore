<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('region','id')->all();
    }

    public function area()
    {
        return $this->belongsTo('App\Area','area_id','id');
    }
}
