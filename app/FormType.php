<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    public function forms()
    {
        return $this->hasMany('App\Form');
    }

    public static function getLists(){
    	return self::orderBy('form_type')
    	->lists('form_type','id')
    	->all();
    }
}
