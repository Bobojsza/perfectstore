<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::lists('distributor','id')->all();
    }

     public function region()
    {
        return $this->belongsTo('App\Region','region_id','id');
    }
}
