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

class FormCategoryTaggingTableSeeder extends Seeder
{
    public function run()
	{
		Model::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		Excel::selectSheets('Sheet1')->load('/database/seeds/seed_files/Category Tagging.xlsx', function($reader) {
			$records = $reader->get();
			$records->each(function($row) {
				if(!is_null($row->category)){
					$form_category = FormCategory::where('category',$row->category)->first();
					// dd($form_category);
					if(!empty($form_category)){
						$form_category->sos_tagging = $row->sos;
						$form_category->osa_tagging = $row->osa;
						$form_category->secondary_display = $row->secondary_display;
						$form_category->update();
					}
				}
			});
		});

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
	}
}
