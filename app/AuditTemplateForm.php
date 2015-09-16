<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTemplateForm extends Model
{
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\FormCategory','form_category_id','id');
    }

    public function template()
    {
        return $this->belongsTo('App\AuditTemplate','audit_template_id','id');
    }

    public function form(){
    	return $this->belongsTo('App\Form','form_id','id');
    }

    public static function getLastCount($id){
        return self::orderBy('order', 'desc')->first();
    }

    public static function getForms($id){
    	return self::with('category')
    		->with('template')
    		->with('form')
    		->where('audit_template_id',$id)
            ->orderBy('order')
            ->get();
    }
}
