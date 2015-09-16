<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use App\Form;

class FormsController extends Controller
{
	
	public function inputs(){
		$iputForms = array(3,4);
		$inputs = Form::select('id as name','prompt as input')
			->whereIn('form_type_id',$iputForms)
			->get();
		return response()->json($inputs);
	}

	public function forms(){
		$forms = Form::select('forms.id','form_groups.group_desc as group','form_types.form_type as type','forms.prompt')
			->join('form_groups', 'forms.form_group_id' ,'=', 'form_groups.id')
			->join('form_types', 'forms.form_type_id' ,'=', 'form_types.id')
			->get();

		

        return Datatables::of($forms)	
            ->make(true);

		// return Datatables::of(Form::all())->make(true);
	}
}
