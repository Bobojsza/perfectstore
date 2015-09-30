<?php

use Illuminate\Database\Seeder;
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

class ImportFormsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('forms')->truncate();
        DB::table('single_selects')->truncate();
        DB::table('form_single_selects')->truncate();
        DB::table('multi_selects')->truncate();
        DB::table('form_multi_selects')->truncate();

        DB::table('audit_template_forms')->truncate();

        Excel::selectSheets('Forms')->load('/database/seeds/seed_files/Forms.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if((!is_null($row->client)) && ($row->client == 'MT Puregold Aspirational')){
					if(strtoupper($row->type) == 'DOUBLE'){
						$form_type = FormType::where('form_type', "NUMERIC")->first();
					}else{
						$form_type = FormType::where('form_type', strtoupper($row->type))->first();
					}
					$form_group = FormGroup::where('group_desc',$row->group)->first();
					
					
					$required = ($row->required == 'yes') ? 1 : 0;
					$form = Form::where('form_group_id',$form_group->id)
						->where('form_type_id',$form_type->id)
						->where('prompt',strtoupper($row->prompt))
						->where('required',$required)
						->where('expected_answer',0)
						->where('exempt',0)
						->first();
					if(count($form) == 0){
						$form = Form::create(array(
					    	'form_group_id' => $form_group->id,
					    	'form_type_id' => $form_type->id,
					    	'prompt' => strtoupper($row->prompt),
					    	'required' => $required,
					    	'expected_answer' => 0,
					    	'exempt' => 0,
					    ));

					    if($form_type->id == 9){
					    	$choices = explode("~", $row->choices);
					    	foreach ($choices as $choice) {
					    		
					    		$sel = MultiSelect::where('option',$choice)->first();
					    		if(empty($sel)){
					    			$sel = MultiSelect::create(array('option' => strtoupper($choice)));
					    		}
					    		FormMultiSelect::create(array('form_id' => $form->id, 'multi_select_id' => $sel->id));
					    	}
					    }

					    if($form_type->id == 10){
					    	$choices = explode("~", $row->choices);
					    	foreach ($choices as $choice) {
					    		if($choice == "1"){
					    			$opt = "YES";
					    		}elseif($choice == "0"){
					    			$opt = "NO";
					    		}else{
					    			$opt = $choice;
					    		}
					    		// echo $opt;
					    		$sel = SingleSelect::where('option',$opt)->first();
					    		if(empty($sel)){
					    			$sel = SingleSelect::create(array('option' => strtoupper($opt)));
					    		}
					    		FormSingleSelect::create(array('form_id' => $form->id, 'single_select_id' => $sel->id));
					    	}
					    }
					}

					$template = AuditTemplate::where('template',$row->client)->first();
					$category = FormCategory::where('category', $row->activity)->first();

					$lastCategory = AuditTemplateForm::getLastCategoryCount($template->id);
					$lastGroupCount = AuditTemplateForm::getLastGroupCount($template->id, $category->id);
					
					$catCnt = 1;
					$grpCnt = 1;


					if(!empty($lastCategory)){
						if($lastCategory->form_category_id == $category->id){
							$catCnt = $lastCategory->category_order;
						}else{
							$existingCat = AuditTemplateForm::where('form_category_id',$category->id)
								->where('audit_template_id',$template->id)
								->first();
							if(empty($existingCat)){
								$catCnt = $lastCategory->category_order;
								$catCnt++;
							}else{
								$catCnt = $existingCat->category_order;
							}
							
						}	
					}

					if(count($lastGroupCount) > 0){
						$grpCnt = $lastGroupCount->order;
						$grpCnt++;
					}

					AuditTemplateForm::create(array(
						'category_order' => $catCnt,
						'order' => $grpCnt ,
						'form_category_id' => $category->id,
						'audit_template_id' => $template->id, 
						'form_id' => $form->id
						));
				   
					
				}
			});

		});

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
    }
}
