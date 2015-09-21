@extends('layouts.default')

@section('content')

@include('shared.notifications')


<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">New Form</h3>
				</div>
				{!! Form::open(array('route' => 'form.store')) !!}
					<div class="box-body">

						<div class="form-group">
							<label>Form Category</label>
							{!! Form::select('formgroup', $formgroups, 1,['class' => 'form-control', 'id' => 'formgroup']) !!}
						</div>

						<div class="form-group">
							{!! Form::label('prompt', 'Prompt Text'); !!}
							{!! Form::text('prompt',null,['class' => 'form-control','placeholder' => 'Prompt Text']) !!}
						</div>

						<div class="form-group">
							<label>Form Type</label>
							{!! Form::select('formtype', $activitytypes, 1,['class' => 'form-control', 'id' => 'formtype']) !!}
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
						{!! link_to_route('form.index','Back',array(),['class' => 'btn btn-default']) !!}
					</div>
				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

@section('page-script')
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
			default:
				showOne('1');
		}
	});

	

	$('#formula').atwho({
    at: ":", 
	    data: "{{ action('Api\FormsController@inputs') }}",
	    displayTpl: '<li>${name}<small>_${input}</small></li>',
	    insertTpl: ":${name}_${input}:",
	})

@endsection