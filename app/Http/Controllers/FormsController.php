<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FormGroup;
use App\FormType;
use App\Form;
use App\MultiSelect;
use App\SingleSelect;
use App\FormSingleSelect;
use App\FormMultiSelect;
use App\FormFormula;

class FormsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$forms = Form::with('type')->get();
		return view('form.index',compact('forms'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$formgroups = FormGroup::lists('group_desc','id')->all();
		$activitytypes = FormType::lists('form_type','id')->all();
		$multiselects = MultiSelect::lists('option','id')->all();
		$singleselects = SingleSelect::lists('option','id')->all();
		return view('form.create',compact('formgroups', 'activitytypes', 'multiselects', 'singleselects'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
		    'prompt' => 'required|max:100|unique_with:forms, formgroup = form_group_id, formtype = form_type_id',
		    'formgroup' => 'required|not_in:0',
		    'formtype' => 'required|not_in:0'
		]);

		\DB::beginTransaction();

		try {
			$form = new Form;
			$form->form_group_id = $request->formgroup;
			$form->form_type_id = $request->formtype;
			$form->prompt = $request->prompt;
			$form->required = ($request->required == '1') ? 1 : 0;
			$form->expected_answer = ($request->expected_answer == '1') ? 1 : 0;
			$form->exempt = ($request->exempt == '1') ? 1 : 0;
			$form->save();

			if($request->formtype == 9){
				$multiData = array();
				foreach ($request->multiselect as $option) {
					$multiData[] = array('form_id' => $form->id, 'multi_select_id' => $option);
				}
				if(count($multiData) > 0){
					FormMultiSelect::insert($multiData);
				}
			}

			if($request->formtype == 10){
				$singleData = array();
				foreach ($request->singleselect as $option) {
					$singleData[] = array('form_id' => $form->id, 'single_select_id' => $option);
				}
				if(count($singleData) > 0){
					FormSingleSelect::insert($singleData);
				}
			}

			if($request->formtype == 11){
				if ($request->has('formula')) {
				    $formformula = new FormFormula;
				    $formformula->form_id = $form->id;
				    $formformula->formula = $request->formula;
				    $formformula->save();
				}
			}

			\DB::commit();

			Session::flash('flash_message', 'Form successfully added!');
			return redirect()->route("form.index");

		} catch (Exception $e) {
			DB::rollBack();
			return redirect()->back();
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
