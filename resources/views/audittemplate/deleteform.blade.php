@extends('layouts.default')

@section('content')

@include('shared.notifications')


<section class="content">
   {!! Form::open(array('method' => 'delete', 'action' => array('AuditTemplateController@destroyform', $audit_form->id ), 'class' => 'disable-button')) !!}                       
   <div class="row">
      <div class="col-md-12 col-xs-12">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title">Delete "{{ $audit_form->form->prompt }} " Form</h3>
            </div>
            
               <div class="box-body">
                  <div class="row">
                     <div class="form-group col-md-6">
                        {!! Form::label('category', 'Form Category'); !!}
                        {!! Form::text('category',$audit_form->category->category,['class' => 'form-control','placeholder' => 'Form Category']) !!}
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-md-6">
                        {!! Form::label('group', 'Form Group'); !!}
                        {!! Form::text('group',$audit_form->group->group_desc,['class' => 'form-control','placeholder' => 'Form Group']) !!}
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-md-6">
                        {!! Form::label('prompt', 'Prompt Text'); !!}
                        {!! Form::text('prompt',$audit_form->form->prompt,['class' => 'form-control','placeholder' => 'Prompt Text']) !!}
                     </div>
                  </div>

                   <div class="row">
                     <div class="form-group col-md-6">
                        {!! Form::label('formtype', 'Form Type'); !!}
                        {!! Form::text('category',$audit_form->form->type->form_type,['class' => 'form-control','placeholder' => 'Form Type']) !!}
                     </div>
                  </div

               </div>

               <div class="box-footer">
                  {!! Form::submit('Delete', array('class'=> 'btn btn-danger','onclick' => "if(!confirm('Are you sure to delete this record?')){return false;};")) !!}
                  {!! link_to_route('audittemplate.form','Back',$audit_form->audit_template_id,['class' => 'btn btn-default']) !!}
               </div>
            
           </div>
      </div>
   </div>
   {!! Form::close() !!}

</section>
@endsection

@section('page-script')

       
@endsection