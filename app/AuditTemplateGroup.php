<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTemplateGroup extends Model
{
    public $timestamps = false;

    public static function getLastOrder($id){
    	return self::where('audit_template_category_id',$id)
			->groupBy('group_order')
			->orderBy('group_order', 'desc')->first();
    }

    public static function categoryExist($category_id, $group_id){
    	return self::where('audit_template_category_id',$category_id)
			->where('form_group_id',$group_id)->first();
    }

    public function group()
    {
        return $this->belongsTo('App\FormGroup','form_group_id','id');
    }

    public function templatecategory()
    {
        return $this->belongsTo('App\AuditTemplateCategory','audit_template_category_id','id');
    }

    public function forms()
    {
        return $this->hasMany('App\AuditTemplateForm','audit_template_group_id','id');
    }
}
