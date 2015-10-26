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
	

    public static function insertForm($template,$type,$required,$prompt,$choices,$choices2 = null,$con_datas = null){
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
				'expected_answer' => 0,
				'exempt' => 0,
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
	
				$sel = SingleSelect::where('option',$opt)->first();
				if(empty($sel)){
					$sel = SingleSelect::create(array('option' => strtoupper($opt)));
				}
				FormSingleSelect::create(array('form_id' => $form->id, 'single_select_id' => $sel->id));
			}
		}

		if($form_type->id == 11){
			FormFormula::create(['form_id' => $form->id, 'formula' => $choices, 'formula_desc' => $choices2]);
		}

		if($form_type->id == 12){

			foreach ($con_datas as $con_data) {
				$con = FormCondition::create(['form_id' => $form->id,
					'option' => $con_data['option'], 
					'condition' => $con_data['condition'], 
					'condition_desc' => $con_data['condition_desc']]);	
			}
		}
		return $form;
    }
}
