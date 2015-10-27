@extends('layouts.default')

@section('content')

@include('shared.notifications')


<section class="content">
	{!! Form::open(array('route' => array('audittemplate.storeform', $audittemplate->id),'id' =>'addform')) !!}
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add Form to {{ $audittemplate->template }}</h3>
				</div>
				
					<div class="box-body">
                  <div class="row">
                     <div class="form-group col-md-6">
                           {!! Form::label('category', 'Form Category'); !!}
                           {!! Form::select('category', $formcategories, null,['class' => 'form-control', 'id' => 'category']) !!}
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-md-6">
                           {!! Form::label('group', 'Form Group'); !!}
                           {!! Form::select('group', $formgroups, null,['class' => 'form-control', 'id' => 'group']) !!}
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-md-6">
                           {!! Form::label('prompt', 'Prompt Text'); !!}
                           {!! Form::text('prompt',null,['class' => 'form-control','placeholder' => 'Prompt Text']) !!}
                     </div>
                  </div>

                   <div class="row">
                     <div class="form-group col-md-6">
                           {!! Form::label('formtype', 'Form Type'); !!}
                           {!! Form::select('formtype', $activitytypes, 1,['class' => 'form-control', 'id' => 'formtype']) !!}
                     </div>
                  </div>

                  <div id="mselect" class="form-hide form-group">
                     <label>Multi Item Select Options</label>
                     {!! Form::select('multiselect[]', $multiselects, null,['multiple' => 'multiple','class' => 'form-multiple', 'id' => 'multiselect', '']) !!}
                  </div>

                  <div id="sselect" class="form-hide form-group">
                     <label>Single Item Select Options</label>
                     {!! Form::select('singleselect[]', $singleselects, null,['multiple' => 'multiple','class' => 'form-multiple', 'id' => 'singleselect', '']) !!}
                  </div>


                  <div id="compute" class="form-hide">
                     <div class="form-group">
                        <label>Formula</label>
                        {!! Form::textarea('formula',null,['class' => 'form-control','placeholder' => 'Formula', 'rows' => '3','id' => 'formula']) !!}
                     </div>
                  </div>

                  <div id="condition" class="form-hide">

                     <div class="row">
                        <div class="form-group col-md-6">
                           <label>Condition</label>
                           {!! Form::text('condition[]',null,['class' => 'form-control','placeholder' => 'Condition']) !!}
                           {!! Form::textarea('selection[]',null,['class' => 'form-control condi','placeholder' => 'Selection', 'rows' => '3','id' => 'selection']) !!}
                        </div>
                     </div>


                     <input type='button' value='Add New Condition' id='addButton'>

                   </div>


                  <div class="checkbox">
                     <label>{!! Form::checkbox('required', '1') !!} Required Form</label>
                  </div>

                  <div class="checkbox">
                     <label>{!! Form::checkbox('expected_answer', '1') !!} With Expected Answer</label>
                  </div>

                  <div class="checkbox">
                     <label>{!! Form::checkbox('exempt', '1') !!} With Excempt</label>
                  </div>

					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('audittemplate.form','Back',$audittemplate->id,['class' => 'btn btn-default']) !!}
					</div>
				
			  </div>
		</div>
	</div>

	{!! Form::close() !!}
</section>
@endsection

@section('page-script')

$(document).ready(function (){
   function showOne(id) { 
      $('.form-hide').hide(1000);
      $('#'+id).show(1000); 
   } 

   $('#multiselect').multiSelect();
   $('#singleselect').multiSelect();

   $('#formtype').change(function() {
      var sel = $(this).val();
      switch(sel) {
         case '9':
            showOne('mselect');
            break;
         case '10':
            showOne('sselect');
            break;
         case '11':
            showOne('compute');
            break;
         case '12':
            showOne('condition');
            break;
         default:
            showOne('1');
      }
   });

   

   $('#formula').atwho({
    at: ":", 
      data: "{{ action('Api\FormsController@inputs') }}",
      displayTpl: '<li><small>${input}</small>_${name}</li>',
      insertTpl: ":${input}_${name}:",
      searchKey: "input",
   })     

   $('.condi').atwho({
    at: ":", 
      data: "{{ action('Api\FormsController@inputs') }}",
      displayTpl: '<li><small>${input}</small>_${name}</li>',
      insertTpl: ":${input}_${name}:",
      searchKey: "input",
   })      

   $('#addButton').click(function(){
      var clone = $("#condition > div:last").clone().find("input,textarea").val("").end().insertAfter("#condition > div:last");;
      
      $('.condi').atwho({
       at: ":", 
         data: "{{ action('Api\FormsController@inputs') }}",
         displayTpl: '<li><small>${input}</small>_${name}</li>',
         insertTpl: ":${input}_${name}:",
         searchKey: "input",
      })

   });
});
       
@endsection