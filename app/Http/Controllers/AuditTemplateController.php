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
use App\FormRepository;
use App\FormCondition;
use App\FormFormula;
use App\FormMultiSelect;
use App\FormSingleSelect;

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
		$template = AuditTemplate::findOrFail($id);
		$tempforms = AuditTemplateForm::where('audit_template_id',$template->id)->get();
		$forms = Form::where('audit_template_id',$template->id)->get();
		foreach ($forms as $form) {
			FormFormula::where('form_id',$form->id)->delete();
			FormCondition::where('form_id',$form->id)->delete();
			FormMultiSelect::where('form_id',$form->id)->delete();
			FormSingleSelect::where('form_id',$form->id)->delete();
		}
		AuditTemplateForm::where('audit_template_id',$template->id)->delete();
		Form::where('audit_template_id',$template->id)->delete();
		$template->delete();

		Session::flash('flash_message', 'Template successfully deleted!');
		return redirect()->route("audittemplate.index");
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
		// dd($request->all());

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
					'required' => ($request->required == '1') ? 1 : 0,
					'expected_answer' => ($request->expected_answer == '1') ? 1 : 0,
					'exempt' => ($request->exempt == '1') ? 1 : 0,
				));

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
					$text = $request->formula;
					preg_match_all('/:(.*?):/', $text, $matches);					
					$index = array();
					foreach ($matches[1] as $value) {
						$split_up = explode('_', $value);
		  				$last_item = $split_up[count($split_up)-1];
						$index[] = $last_item;
					}
					$formula1 = $text;
					foreach ($matches[1] as $key => $a ){
						$formula1 = str_replace(':'.$a.':',$index[$key], $formula1);
					}
				    $formformula = new FormFormula;
				    $formformula->form_id = $form->id;
				    $formformula->formula = $formula1;
				    $formformula->formula_desc = $request->formula;
				    $formformula->save();
				}
			}

			if($request->formtype == 12 ){
				if ($request->has('condition')) {
					
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

			AuditTemplateForm::insert(array(
				'category_order' => $catCnt,
				'group_order' => $grpCnt,
				'order' => $order,
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

	public function deleteform($id){
		$audit_form = AuditTemplateForm::with('form')
			->findOrFail($id);
		return view('audittemplate.deleteform',compact('audit_form'));

	}

	public function destroyform($id){
		$audit_form = AuditTemplateForm::with('form')
			->findOrFail($id);
		$audit_form->delete();
		Form::where('id', $audit_form->form_id)->delete();
		Session::flash('flash_message', 'Template form succesfully deleted!');

		return redirect()->route("audittemplate.form",$audit_form->audit_template_id);
	}

	public function duplicate($id){
		$template = AuditTemplate::findOrFail($id);
		return view('audittemplate.duplicate', compact('template'));
	}

	public function duplicatetemplate(Request $request, $id){
		$template = AuditTemplate::findOrFail($id);
		\DB::beginTransaction();

        try {
            $this->validate($request, [
				'template' => 'required|unique:audit_templates|max:100',
			]);

			$newtemplate = new AuditTemplate;
			$newtemplate->template = $request->template;
			$newtemplate->save();

			$oldforms = AuditTemplateForm::where('audit_template_id',$template->id)->get();
			// dd($oldforms);
			foreach ($oldforms as $oldform) {
				$form = Form::find($oldform->form_id);
				if($form->form_type_id == 11){
					$choice = FormFormula::where('form_id',$form->id)->first();
					
					$index1 = array();
					$index2 = array();
					preg_match_all('/{(.*?)}/', $choice->formula, $matches);
					foreach ($matches[1] as $key => $a ){
						$data = Form::find($a);
						$other_form = FormRepository::duplicate($newtemplate,$data->id);
						$index1[$a] = $other_form->id;
						$index2[$a] = $other_form->prompt.'_'.$other_form->id;
						
					}
					$formula1 = $choice->formula;
					$formula2 = $choice->formula_desc;
					foreach ($matches[1] as $key => $a ){
						$formula1 = str_replace('{'.$a.'}',$index1[$a], $formula1);
						$formula2 = str_replace('{'.$a.'}', ' :'.$index2[$a].': ', $formula2);
						
					}
					$newform = FormRepository::duplicate($newtemplate,$oldform->form_id,$formula1,$formula2);
				
				}elseif ($form->form_type_id == 12) {
					$choices = FormCondition::where('form_id',$form->id)->get();

					foreach ($choices as $choice) {
						// $with_value = preg_match('/{(.*?)}/', $choice->condition, $match);
						$option = $choice->condition;
						$x1 = array();
						$x2 = array();
						$_opt1 = "";
						$_opt2 = "";
						if(!empty($choice->condition)){
							$codes = explode('^', $choice->condition);
							if(count($codes)> 0){
								foreach ($codes as $code) {
									$other_data = Form::find($code);
									$other_form = FormRepository::duplicate($newtemplate,$other_data->id);
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
						
						$data_con[] = ['option' => $choice->option, 'condition' => $_opt1, 'condition_desc' => $_opt2];
						
					}
					$newform = FormRepository::duplicate($newtemplate,$oldform->form_id,array(),array(),$data_con);
				}
				else{
					$newform = FormRepository::duplicate($newtemplate,$oldform->form_id);
				}

				// dd($newform->id);
				AuditTemplateForm::insert(array(
					'category_order' => $oldform->category_order,
					'order' => $oldform->order,
					'form_category_id' => $oldform->form_category_id,
					'form_group_id' => $oldform->form_group_id,
					'audit_template_id' => $newtemplate->id, 
					'form_id' => $newform->id,
				));
			}

            \DB::commit();

            Session::flash('flash_message', 'Template successfully added!');
			return redirect()->route("audittemplate.form",$newtemplate->id);

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            Session::flash('flash_message', 'An error occured in adding form!');
            return redirect()->back();
        }

		

	}
}
