<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::orderBy('distributor')->lists('distributor','id')->all();
    }

}
