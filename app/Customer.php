<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function account()
    {
        return $this->belongsTo('App\Account','account_id','id');
    }

    public static function getLists(){
    	return self::lists('customer','id')->all();
    }
}
