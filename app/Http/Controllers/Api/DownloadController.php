<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\AuditTemplateForm;
use App\Form;
use App\FormSingleSelect;
use App\FormMultiSelect;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

class DownloadController extends Controller
{
    public function index(Request $request){
        $user = $request->id;
        $type = $request->type;

        $user = User::find($user);
        $storelist = $user->stores()->orderBy('store')->get();

        $list = array();
        foreach ($storelist as $store) {
            $list[] = $store->audit_template_id;
        }

        $forms = Form::whereIn('forms.audit_template_id',$list)
                // ->where('form_type_id',10)
                ->get();
        $form_ids = array();
        foreach ($forms as $form) {
            $form_ids[] = $form->id;
        }

        // get store list
        if($type == 1){
            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('stores.txt');
            foreach ($storelist as $store) {
                $data[0] = $store->store_code;
                $data[1] = $store->store;
                $data[2] = $store->grade_matrix_id;
                $data[3] = $store->audit_template_id;
                $writer->addRow($data); 
            }

            $writer->close();
        }

        // get template questions
        if($type == 2){
            $forms = AuditTemplateForm::select('audit_template_forms.id', 'audit_template_forms.category_order', 'audit_template_forms.order',
                'audit_template_forms.form_category_id', 'form_categories.category', 'audit_template_forms.form_group_id', 'form_groups.group_desc',
                'audit_template_forms.audit_template_id', 'audit_template_forms.form_id', 'forms.form_type_id', 'forms.prompt', 'forms.required', 
                'forms.expected_answer', 'forms.exempt')
                ->join('form_categories', 'form_categories.id', '=', 'audit_template_forms.form_category_id')
                ->join('form_groups', 'form_groups.id', '=', 'audit_template_forms.form_group_id')
                ->join('forms', 'forms.id', '=', 'audit_template_forms.form_id')
                ->whereIn('audit_template_forms.audit_template_id',$list)
                ->get();
            
            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('questions.txt');
            foreach ($forms as $form) {
                $data[0] = $form->id;
                $data[1] = $form->category_order;
                $data[2] = $form->order;
                $data[3] = $form->form_category_id;
                $data[4] = $form->category;
                $data[5] = $form->form_group_id;
                $data[6] = $form->group_desc;
                $data[7] = $form->audit_template_id;
                $data[8] = $form->form_id;
                $data[9] = $form->form_type_id;
                $data[10] = $form->prompt;
                $data[11] = $form->required;
                $data[12] = $form->expected_answer;
                $data[13] = $form->exempt;
                $writer->addRow($data); 
            }

            $writer->close();
        }

        // get template forms
        if($type == 3){
            $forms = Form::whereIn('forms.audit_template_id',$list)
                ->get();
            
            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('forms.txt');
            foreach ($forms as $form) {
                $data[0] = $form->id;
                $data[1] = $form->audit_template_id;
                $data[2] = $form->form_type_id;
                $data[3] = $form->prompt;
                $data[4] = $form->required;
                $data[5] = $form->expected_answer;
                $data[6] = $form->exempt;
                $writer->addRow($data); 
            }

            $writer->close();
        }

        // get single selects
        if($type == 4){
            $selections = FormSingleSelect::select('single_selects.id', 'single_selects.option')
                ->join('single_selects', 'single_selects.id', '=', 'form_single_selects.single_select_id')
                ->whereIn('form_single_selects.form_id',$form_ids)
                ->groupBy('single_selects.id')
                ->get();

            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('single_selects.txt');
            foreach ($selections as $selection) {
                $data[0] = $selection->id;
                $data[1] = $selection->option;
                $writer->addRow($data); 
            }

            $writer->close();
        }

        // get multiple selects
        if($type == 5){
            $selections = FormMultiSelect::select('multi_selects.id', 'multi_selects.option')
                ->join('multi_selects', 'multi_selects.id', '=', 'form_multi_selects.multi_select_id')
                ->whereIn('form_multi_selects.form_id',$form_ids)
                ->groupBy('multi_selects.id')
                ->get();
            $writer = WriterFactory::create(Type::CSV); 
            $writer->openToBrowser('multi_selects.txt');
            foreach ($selections as $selection) {
                $data[0] = $selection->id;
                $data[1] = $selection->option;
                $writer->addRow($data); 
            }

            $writer->close();
        }
        
    }
}
