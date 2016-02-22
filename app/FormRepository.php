<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FormGroup;
use App\FormType;
use App\Form;
use App\SingleSelect;
use App\FormSingleSelect;
use App\MultiSelect;
use App\FormMultiSelect;
use App\AuditTemplate;
use App\AuditTemplateForm;
use App\FormCategory;
use App\FormFormula;
use App\FormCondition;

class FormRepository extends Model
{
	public static function duplicate($template,$oldform_id,$choices = null,$choices2 = null,$con_datas = null){
		$form = Form::find($oldform_id);

		$newform = Form::create(array(
				'audit_template_id' => $template->id,
				'form_type_id' => $form->form_type_id,
				'prompt' => $form->prompt,
				'required' => $form->required,
				'expected_answer' => $form->expected_answer,
				'default_answer' => $form->default_answer,
				'exempt' => $form->exempt,
			));

		if($form->form_type_id == 9){
			$choices = FormMultiSelect::where('form_id',$form->id)->get();
			foreach ($choices as $choice) {
				FormMultiSelect::insert(array('form_id' => $newform->id, 'multi_select_id' => $choice->multi_select_id));
			}
		}

		if($form->form_type_id == 10){
			$choices = FormSingleSelect::where('form_id',$form->id)->get();
			foreach ($choices as $choice) {
				FormSingleSelect::insert(array('form_id' => $newform->id, 'single_select_id' => $choice->single_select_id));
			}
		}

		if($form->form_type_id == 11){
			FormFormula::insert(['form_id' => $newform->id, 'formula' => $choices, 'formula_desc' => $choices2]);
		}

		if($form->form_type_id == 12){

			foreach ($con_datas as $con_data) {
				$con = FormCondition::insert(['form_id' => $newform->id,
					'option' => $con_data['option'], 
					'condition' => $con_data['condition'], 
					'condition_desc' => $con_data['condition_desc']]);
				// dd($con);	
			}
		}

		return $newform;
	}
	

    public static function insertForm(
    	$template,
    	$code,
    	$type,
    	$required,
    	$prompt,
    	$choices,
    	$expected_answer,
    	$image,
    	$choices2 = null,
    	$con_datas = null,
    	$default_answer = null){
    	if(strtoupper($type) == 'DOUBLE'){
			$form_type = FormType::where('form_type', "NUMERIC")->first();
		}else{
			$form_type = FormType::where('form_type', strtoupper($type))->first();
		}

		switch ($required) {
			case 't':
				$required = 1;
				break;
			case 'yes':
				$required = 1;
				break;
			case 'f':
				$required = 0;
				break;
			case 'no':
				$required = 0;
				break;
			default:
				# code...
				break;
		}
		

		$form = Form::create(array(
				'audit_template_id' => $template->id,
				'form_type_id' => $form_type->id,
				'prompt' => strtoupper($prompt),
				'required' => $required,
				'exempt' => 0,
				'default_answer' => $default_answer,
				'image' => $image,
				'code' => $code
			));


		if($form_type->id == 9){
			$choices = explode("~", $choices);
			foreach ($choices as $choice) {
				
				$sel = MultiSelect::where('option',$choice)->first();
				if(empty($sel)){
					$sel = MultiSelect::create(array('option' => strtoupper($choice)));
				}
				FormMultiSelect::create(array('form_id' => $form->id, 'multi_select_id' => $sel->id));
			}

			if(!empty($default_answer)){
				$_form = Form::find($form->id);
				$ans = MultiSelect::where('option',strtoupper($default_answer))->first();
				$_form->default_answer = $ans->id;
				$_form->update();
			}
		}

		if($form_type->id == 10){
			$choices = explode("~", $choices);
			foreach ($choices as $choice) {
				if($choice == "1"){
					$opt = "YES";
				}elseif($choice == "0"){
					$opt = "NO";
				}else{
					$opt = $choice;
				}
	
				$sel = SingleSelect::firstOrCreate(array('option' => strtoupper($opt)));
				FormSingleSelect::create(array('form_id' => $form->id, 'single_select_id' => $sel->id));
			}

			if(!empty($expected_answer)){
				$_form = Form::find($form->id);
				// $ans = SingleSelect::where('option',strtoupper($expected_answer))->first();
				// $_form->expected_answer = $ans->id;
				// $_form->update();

				$ans = explode("^", $expected_answer);
				$pos_ans = [];
				foreach ($ans as $value) {
					$_ans = SingleSelect::where('option',strtoupper($value))->first();
					$pos_ans[] = $_ans->id;
				}
				if(!empty($pos_ans)){
					$_form->expected_answer = implode("^", $pos_ans);
					$_form->update();
				}
			}



			if(!empty($default_answer)){
				$_form = Form::find($form->id);
				// $ans = SingleSelect::where('option',strtoupper($default_answer))->first();
				// $_form->default_answer = $ans->id;
				// $_form->update();
				$ans = explode("^", $default_answer);
				$pos_ans = [];
				foreach ($ans as $value) {
					$_ans = SingleSelect::where('option',strtoupper($value))->first();
					$pos_ans[] = $_ans->id;
				}
				if(!empty($pos_ans)){
					$_form->default_answer = implode("^", $pos_ans);
					$_form->update();
				}
			}
			
		}

		if($form_type->id == 11){
			// dd($choices2);
			FormFormula::create(['form_id' => $form->id, 'formula' => $choices, 'formula_desc' => $choices2]);
		}

		if($form_type->id == 12){

			foreach ($con_datas as $con_data) {
				$con = FormCondition::create(['form_id' => $form->id,
					'option' => $con_data['option'], 
					'condition' => $con_data['condition'], 
					'condition_desc' => $con_data['condition_desc']]);	
			}

			if(!empty($expected_answer)){
				$_form = Form::find($form->id);

				$ans = explode("^", $expected_answer);
				$pos_ans = [];
				foreach ($ans as $value) {
					$_ans = FormCondition::where('option',strtoupper($value))
						->where('form_id',$form->id)
						->first();
					$pos_ans[] = $_ans->id;
				}
				if(!empty($pos_ans)){
					$_form->expected_answer = implode("^", $pos_ans);
					$_form->update();
				}
				
			}

			if(!empty($default_answer)){
				if(!empty($default_answer)){
					$_form = Form::find($form->id);
					$ans = FormCondition::where('option',strtoupper($default_answer))
						->where('form_id',$form->id)
						->first();
					if(!empty($ans)){
						$_form->default_answer = $ans->id;
						$_form->update();
					}
				}
				
				
			}
		}

		return $form;
    }
}
