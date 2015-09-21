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
        return view('audittemplate.forms',compact('audittemplate', 'forms'));
    }

    public function addform($id){
        $audittemplate = AuditTemplate::findOrFail($id);
        $formcategories = FormCategory::getLists();
        $formgroups = FormGroup::getLists();
        return view('audittemplate.addform',compact('audittemplate','formcategories','formgroups'));
    }

    public function storeform(Request $request, $id){
        // dd($request->all());
        $lastCount = AuditTemplateForm::getLastCount($id);
        $cnt = 0;
        if(!empty($lastCount)){
             $cnt = $lastCount->order;
        }
       
        if ($request->has('forms_id')) {
            $forms = array();
            foreach ($request->forms_id as $form) {
                $cnt ++;
                $forms[] = array('order' => $cnt ,
                    'form_category_id' => $request->category,
                    'audit_template_id' => $id, 
                    'form_id' => $form
                    );
            }
            if(count($forms) > 0){
                AuditTemplateForm::insert($forms);
            }
        }

        Session::flash('flash_message', 'Template successfully added!');

        return redirect()->route("audittemplate.form",$id);
    }

    public function updateorder(Request $request, $id){
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
