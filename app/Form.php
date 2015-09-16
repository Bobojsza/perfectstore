<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public $timestamps = false;

    public static function getLists(){
    	return self::select('forms.id', \DB::raw('CONCAT(form_type, " - ", prompt ) AS prompt'))
    		->join('form_types', 'form_types.id', '=', 'forms.form_type_id')
    		->lists('prompt','id')->all();
    }

    public function type()
    {
        return $this->belongsTo('App\FormType','form_type_id','id');
    }

    public function group()
    {
        return $this->belongsTo('App\FormGroup','form_group_id','id');
    }
}
