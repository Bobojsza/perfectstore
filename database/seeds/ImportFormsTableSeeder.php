<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\FormGroup;
use App\FormType;
use App\Form;

class ImportFormsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('forms')->truncate();
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
						Form::create(array(
					    	'form_group_id' => $form_group->id,
					    	'form_type_id' => $form_type->id,
					    	'prompt' => strtoupper($row->prompt),
					    	'required' => $required,
					    	'expected_answer' => 0,
					    	'exempt' => 0,
					    ));
					}
				}
			});

		});

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		Model::reguard();
    }
}
