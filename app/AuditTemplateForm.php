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

	public static function getLastOrder($group_id){
		return self::where('audit_template_group_id',$group_id)
			->groupBy('order')
			->orderBy('order', 'desc')->first();
	}
}
