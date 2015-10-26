<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AuditTemplate;
use App\FormCategory;
use App\FormGroup;
use App\Form;
use App\AuditTemplateForm;
use App\FormType;
use App\MultiSelect;
use App\SingleSelect;

class AuditTemplateController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$templates = AuditTemplate::all();
		return view('audittemplate.index', compact('templates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('audittemplate.create');
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
			'template' => 'required|unique:audit_templates|max:100',
		]);

		$template = new AuditTemplate;
		$template->template = $request->template;
		$template->save();

		Session::flash('flash_message', 'Template successfully added!');

		return redirect()->route("audittemplate.index");
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

	public function forms($id){
		$audittemplate = AuditTemplate::findOrFail($id);
		$forms = AuditTemplateForm::getForms($id);
		// dd($forms);
		return view('audittemplate.forms',compact('audittemplate', 'forms'));
	}

	public function addform($id){
		$audittemplate = AuditTemplate::findOrFail($id);
		$formcategories = FormCategory::getLists();
		$formgroups = FormGroup::getLists();
		$activitytypes = FormType::getLists();
		$multiselects = MultiSelect::getLists();
		$singleselects = SingleSelect::getLists();
		return view('audittemplate.addform',compact('audittemplate','formcategories','formgroups', 'activitytypes', 'multiselects', 'singleselects'));
	}

	public function storeform(Request $request, $id){
		dd($request->all());

		$this->validate($request, [
            'category' => 'required|not_in:0',
            'group' => 'required|not_in:0',
            'prompt' => 'required',
            'formtype' => 'required|not_in:0'
        ]);

		 \DB::beginTransaction();

        try {
            $template = AuditTemplate::find($id);
			$group = FormGroup::find($request->group);
			$category = FormCategory::find($request->category);
			$form_type = FormType::find($request->formtype);
			$prompt = $request->prompt;
			
			$form = Form::create(array(
					'audit_template_id' => $template->id,
					'form_type_id' => $form_type->id,
					'prompt' => strtoupper($prompt),
					'required' => $request->prompt,
					'expected_answer' => $request->expected_answer,
					'exempt' => $request->exempt,
				));

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

			AuditTemplateForm::insert(array(
				'category_order' => $catCnt,
				'order' => $grpCnt ,
				'form_category_id' => $category->id,
				'form_group_id' => $group->id,
				'audit_template_id' => $template->id, 
				'form_id' => $form->id
				));

            \DB::commit();

            Session::flash('flash_message', 'Template successfully added!');

			return redirect()->route("audittemplate.form",$id);

        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('flash_message', 'An error occured in adding form!');
            return redirect()->back();
        }

		
	}

	public function updateorder(Request $request, $id){


		if($request->has('c_id')){
			$category = array();
			foreach ($request->c_id as $key => $value) {
				$ids = array();
				$records = AuditTemplateForm::select('id')
					->where('category_order', $key)
					->where('audit_template_id', $id)
					->get();

				foreach ($records as $row) {
					$ids[] = $row->id;
				}
				$category[$value] = $ids;
			}

			foreach ($category as $key => $value) {
				AuditTemplateForm::select('id')
					->whereIn('id', $value)
					->update(['category_order' => $key]);
			}
		}

		if ($request->has('p_id')) {
			$forms = array();
			foreach ($request->p_id as $key => $order) {
				$form = AuditTemplateForm::find($key);
				$form->order = $order;
				$form->update();
			}
		}


		Session::flash('flash_message', 'Template order succesfully updated!');

		return redirect()->route("audittemplate.form",$id);
	}
}
