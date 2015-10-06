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
use App\FormFormula;

use App\FormRepository;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;


class ImportAuditTemplateTableSeeder extends Seeder
{
	public function run()
	{
		Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('form_categories')->truncate();
		DB::table('form_groups')->truncate();
		DB::table('forms')->truncate();

		DB::table('single_selects')->truncate();
		DB::table('form_single_selects')->truncate();
		DB::table('multi_selects')->truncate();
		DB::table('form_multi_selects')->truncate();

		DB::table('temp_forms')->truncate();
		DB::table('form_formulas')->truncate();
		DB::table('form_conditions')->truncate();

		DB::table('audit_template_forms')->truncate();

		$reader = ReaderFactory::create(Type::XLSX); // for XLSX files
		$filePath = 'database/seeds/seed_files/Forms.xlsx';
		$reader->open($filePath);

	   // Accessing the sheet name when reading
		foreach ($reader->getSheetIterator() as $sheet) {
			if($sheet->getName() == 'Forms'){
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 0){
						if(!is_null($row[1])){
							$template = AuditTemplate::firstOrCreate(['template' => $row[1]]);
							$category = FormCategory::firstOrCreate(['category' => $row[3]]);
							$group = FormGroup::firstOrCreate(['group_desc' => $row[6]]);

							$type = $row[10];
							if(strtoupper($type) == 'DOUBLE'){
								$form_type = FormType::where('form_type', "NUMERIC")->first();
							}else{
								$form_type = FormType::where('form_type', strtoupper($type))->first();
							}

							if($form_type->id == 11){
								$index1 = array();
								$index2 = array();
								preg_match_all('/{(.*?)}/', $row[11], $matches);
								foreach ($matches[1] as $key => $a ){
									$data = DB::table('temp_forms')->where('code',$a)->first();
									$other_form = FormRepository::insertForm($template,$data->type,$data->required,$data->prompt,$data->choices);
									$index1[$a] = $other_form->id;
									$index2[$a] = $other_form->id.'_'.$other_form->prompt;
									
								}
								$formula1 = $row[11];
								$formula2 = $row[11];
								foreach ($matches[1] as $key => $a ){
									$formula1 = str_replace('{'.$a.'}',$index1[$a], $formula1);
									$formula2 = str_replace('{'.$a.'}', ' :'.$index2[$a].': ', $formula2);
									
								}
								$form = FormRepository::insertForm($template,$row[10],$row[9],$row[8],$formula1,$formula2);
							}elseif ($form_type->id == 12) {
								// preg_match_all('/(.*?){(.*?)}/', $row[11], $matches);
								// $data_con = array();
								// $options = explode("~", $row[11]);
								// foreach ($options as $option) {
								// 	preg_match('/{(.*?)}/', $option, $match);
								// 	$codes = explode('^', $match[1]);
								// 	$x1 = array();
								// 	$x2 = array();
								// 	// foreach ($codes as $code) {
								// 	// 	$other_data = DB::table('temp_forms')->where('code',$code)->first();
								// 	// 	$other_form = FormRepository::insertForm($template,$other_data->type,$other_data->required,$other_data->prompt,$other_data->choices);
								// 	// 	$x1[] = $other_form->id;
								// 	// 	$x2[] = $other_form->id.'_'.$other_form->prompt;
										
								// 	// }
									
								// 	$_opt1 = implode("^", $x1);
								// 	$_opt2 = implode("^", $x2);
								// 	$data_con[] = ['option' => strtok($option, '{'), 'condition' => $_opt1, 'condition_desc' => $_opt2];
									
								// }
								// $form = FormRepository::insertForm($template,$row[10],$row[9],$row[8],$row[11],array(),$data_con);
								
							}else{
								$form = FormRepository::insertForm($template,$row[10],$row[9],$row[8],$row[11]);
							}
						}

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
							'form_group_id' => $group->id,
							'audit_template_id' => $template->id, 
							'form_id' => $form->id
							));
					}
					$cnt++;
			  
				}
			}else {
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 0){
						if(!is_null($row[2])){
							$prompt = addslashes($row[1]);
							DB::statement('INSERT INTO temp_forms (code, prompt, required, type, choices) VALUES ("'.$row[0].'","'.$prompt.'","'.$row[2].'","'.$row[3].'","'.$row[4].'");');
						}
					}
					$cnt++;
			  
				}
			}
		}

		$reader->close();


		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
	}
}
