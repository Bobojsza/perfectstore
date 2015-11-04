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

use App\AuditTemplateCategory;
use App\AuditTemplateGroup;
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
		DB::table('audit_template_groups')->truncate();
		DB::table('audit_template_categories')->truncate();

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
									$index2[$a] = $other_form->prompt.'_'.$other_form->id;
									
								}
								$formula1 = $row[11];
								$formula2 = $row[11];
								foreach ($matches[1] as $key => $a ){
									$formula1 = str_replace('{'.$a.'}',$index1[$a], $formula1);
									$formula2 = str_replace('{'.$a.'}', ' :'.$index2[$a].': ', $formula2);
									
								}
								$form = FormRepository::insertForm($template,$row[10],$row[9],$row[8],$formula1,$formula2);
								
							}elseif ($form_type->id == 12) {
								$options = explode("~", $row[11]);

								preg_match_all('/(.*?){(.*?)}/', $row[11], $matches);
								$data_con = array();
								$options = explode("~", $row[11]);
								foreach ($options as $option) {
									$with_value = preg_match('/{(.*?)}/', $option, $match);
									$x1 = array();
									$x2 = array();
									$_opt1 = "";
									$_opt2 = "";
									if($with_value){
										$codes = explode('^', $match[1]);
									
										if(count($codes)> 0){
											foreach ($codes as $code) {
												$other_data = DB::table('temp_forms')->where('code',$code)->first();
												$other_form = FormRepository::insertForm($template,$other_data->type,$other_data->required,$other_data->prompt,$other_data->choices);
												$x1[] = $other_form->id;
												$x2[] = $other_form->prompt.'_'.$other_form->id;
												
											}
										}
										
										if(count($x1) > 0){
											$_opt1 = implode("^", $x1);
										}
										if(count($x2) > 0){
											$_opt2 = implode("^", $x2);
										}
									}
									
									$data_con[] = ['option' => strtoupper(strtok($option, '{')), 'condition' => $_opt1, 'condition_desc' => $_opt2];
									
								}
								$form = FormRepository::insertForm($template,$row[10],$row[9],$row[8],$row[11],array(),$data_con);
								
							}else{
								$form = FormRepository::insertForm($template,$row[10],$row[9],$row[8],$row[11]);
							}
						}


						$cat_order = 1;
						$a_cat_id = 0;
						$clast_cnt = AuditTemplateCategory::getLastOrder($template->id);
						if(empty($clast_cnt)){
							$a_cat = AuditTemplateCategory::create(['category_order' => $cat_order,
								'audit_template_id' => $template->id, 
								'category_id' => $category->id]);
							$a_cat_id = $a_cat->id;
						}else{
							$cat = AuditTemplateCategory::categoryExist($template->id, $category->id);
							if(empty($cat)){
								$cat_order = $clast_cnt->category_order + 1;
								$a_cat = AuditTemplateCategory::create(['category_order' => $cat_order,
									'audit_template_id' => $template->id, 
									'category_id' => $category->id]);
								$a_cat_id = $a_cat->id;
							}else{
								$a_cat_id = $cat->id;
							}
						}

						$grp_order = 1;
						$a_grp_id = 0;
						$glast_cnt = AuditTemplateGroup::getLastOrder($a_cat_id);
						if(empty($glast_cnt)){
							$a_grp = AuditTemplateGroup::create(['group_order' => $grp_order,
								'audit_template_category_id' => $a_cat_id, 
								'form_group_id' => $group->id]);
							$a_grp_id = $a_grp->id;
						}else{
							$grp = AuditTemplateGroup::categoryExist($a_cat_id, $group->id);
							if(empty($grp)){
								$grp_order = $glast_cnt->group_order + 1;
								$a_grp = AuditTemplateGroup::create(['group_order' => $grp_order,
									'audit_template_category_id' => $a_cat_id, 
									'form_group_id' => $group->id]);
								$a_grp_id = $a_grp->id;
							}else{
								$a_grp_id = $grp->id;
							}
						}


						$order = 1;
						$a_frm_id = 0;
						$last_cnt = AuditTemplateForm::getLastOrder($a_grp_id);
						if(!empty($last_cnt)){
							$order = $last_cnt->order + 1;
						}


						AuditTemplateForm::create(array(
							'audit_template_group_id' => $a_grp_id,
							'order' => $order,
							'audit_template_id' => $template->id, 
							'form_id' => $form->id
							));
					}
					$cnt++;
			  
				}
			}elseif($sheet->getName() == 'Others') {
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
			elseif($sheet->getName() == 'SOS') {
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 0){
						if(!is_null($row[0])){
							$form_category = FormCategory::where('category',$row[0])->first();
							if(!empty($form_category)){
								$form_category->sos_tagging = true;
								$form_category->update();
							}
							
						}
					}
					$cnt++;
			  
				}
			}
			elseif($sheet->getName() == 'OSA') {
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 0){
						if(!is_null($row[0])){
							$form_category = FormCategory::where('category',$row[0])->first();
							if(!empty($form_category)){
								$form_category->osa_tagging = true;
								$form_category->update();
							}
							
						}
					}
					$cnt++;
			  
				}
			}
			elseif($sheet->getName() == 'Secondary') {
				$cnt = 0;
				foreach ($sheet->getRowIterator() as $row) {
					if($cnt > 0){
						if(!is_null($row[0])){
							$form_category = FormCategory::where('category',$row[0])->first();
							if(!empty($form_category)){
								$form_category->secondary_display = true;
								$form_category->update();
							}
							
						}
					}
					$cnt++;
			  
				}
			}else{

			}
		}

		$reader->close();




		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
	}
}
