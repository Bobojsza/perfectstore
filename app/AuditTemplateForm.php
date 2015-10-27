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

	public function group()
	{
		return $this->belongsTo('App\FormGroup','form_group_id','id');
	}

	public function template()
	{
		return $this->belongsTo('App\AuditTemplate','audit_template_id','id');
	}

	public function form(){
		return $this->belongsTo('App\Form','form_id','id');
	}

	public static function getLastCategoryCount($id){
		return self::where('audit_template_id',$id)
			->groupBy('category_order')
			->orderBy('category_order', 'desc')->first();
	}


	public static function getLastGroupCount($id,$form_category_id){
		return self::where('audit_template_id',$id)
			->where('form_category_id',$form_category_id)
			->groupBy('group_order')
			->orderBy('group_order', 'desc')->first();
	}

	public static function getLastFormCount($id,$form_category_id,$form_group_id){
		return self::where('audit_template_id',$id)
			->where('form_category_id',$form_category_id)
			->where('form_group_id',$form_group_id)
			->groupBy('order')
			->orderBy('order', 'desc')->first();
	}

	

	private static function getCategories($id){
		return self::with('category')
			->where('audit_template_id',$id)
			->groupBy('form_category_id')
			->orderBy('category_order')
			->get();
	}
	public static function getForms($id){
		$records = self::getCategories($id);
		foreach ($records as $key => $value) {
			$records[$key]->groups = self::with('form')
			->where('audit_template_id',$id)
			->where('form_category_id',$value->form_category_id)
			->orderBy('group_order')
			->orderBy('order')
			->get();
		}
		return $records;
	}
}
