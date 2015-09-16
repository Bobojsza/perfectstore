@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Audit</h3>
				</div>
				{!! Form::open(array('route' => 'audit.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('description', 'Description'); !!}
	                    	{!! Form::text('description',null,['class' => 'form-control','placeholder' => 'Description']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('start_date', 'Start Date'); !!}
	                    	{!! Form::text('start_date',null,['class' => 'form-control', 'id' => 'start_date']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('end_date', 'End Date'); !!}
	                    	{!! Form::text('end_date',null,['class' => 'form-control', 'id' => 'end_date']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('stores', 'Store'); !!}
	                    	<div id="store_tree"></div>
						</div>

				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('audit.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
@section('page-script')
	$("#start_date,#end_date").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
	$("#start_date,#end_date").datepicker({
		format: 'mm/dd/yyyy',
		calendarWeeks: true,
	    autoclose: true,
	    todayHighlight: true
	});

	$("#store_tree").fancytree({
		extensions: [],
		checkbox: true,
		selectMode: 3,
		source: {
			url: "{{ action('Api\StoreController@stores') }}"
		}

	});

@endsection
