<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormCategory extends Model
{
	protected $fillable = ['category'];
	
    public $timestamps = false;

    public function secondarybrand(){
        return $this->hasMany('App\SecondaryDisplay', 'category_id', 'id');
    }

    public static function getLists(){
    	return self::orderBy('category')
    	->lists('category','id')
    	->all();
    }

    public static function sosTagging(){
    	return self::where('sos_tagging',1)
    	->orderBy('category')
    	->get();
    }

    public static function osaTagging(){
        return self::where('osa_tagging',1)
        ->orderBy('category')
        ->get();
    }

    public static function secondaryDisplay(){
        return self::where('secondary_display',1)
        ->orderBy('category')
        ->get();
    }
}
