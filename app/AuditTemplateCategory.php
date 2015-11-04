<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTemplateCategory extends Model
{
    public $timestamps = false;

    public static function getLastOrder($id){
    	return self::where('audit_template_id',$id)
			->groupBy('category_order')
			->orderBy('category_order', 'desc')->first();
    }

    public static function categoryExist($template_id, $category_id){
    	return self::where('audit_template_id',$template_id)
			->where('category_id',$category_id)->first();
    }

    public static function getCategories($template_id){
        return self::where('audit_template_id',$template_id)
            ->orderBy('category_order')
            ->get();
    }

    public function category()
    {
        return $this->belongsTo('App\FormCategory','category_id','id');
    }

    public function groups()
    {
        return $this->hasMany('App\AuditTemplateGroup','audit_template_category_id','id');
    }
}
