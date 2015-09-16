<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormGroup extends Model
{
    public $timestamps = false;

    public function forms()
    {
        return $this->hasMany('App\Form');
    }

    public static function getLists(){
    	return self::lists('group_desc','id')->all();
    }
}
