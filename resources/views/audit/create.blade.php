@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Audit</h3>
				</div>
				{!! Form::open(array('route' => 'audit.store')) !!}
				  	<div class="box-body">
				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('description', 'Description'); !!}
		                    	{!! Form::text('description',null,['class' => 'form-control','placeholder' => 'Description']) !!}
							</div>
				  		</div>

				  		<div class="row">
				  			<div class="form-group col-xs-6 col-md-3">
						   		{!! Form::label('start_date', 'Start Date'); !!}
		                    	{!! Form::text('start_date',null,['class' => 'form-control', 'id' => 'start_date']) !!}
							</div>

							<div class="form-group col-xs-6 col-md-3">
						   		{!! Form::label('end_date', 'End Date'); !!}
		                    	{!! Form::text('end_date',null,['class' => 'form-control', 'id' => 'end_date']) !!}
							</div>
				  		</div>

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('customers', 'Customer'); !!}
		                    	{!! Form::select('customers', $customers, null,['class' => 'form-control', 'id' => 'customers', 'multiple' => 'multiple']) !!}
							</div>
				  		</div>
				  		
				  		<div class="row">

							<div class="form-group col-md-6">
						   		{!! Form::label('regions', 'Region'); !!}
		                    	{!! Form::select('regions', $regions, null,['class' => 'form-control', 'id' => 'regions', 'multiple' => 'multiple']) !!}
							</div>
				  		</div>

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('distributors', 'Distributor'); !!}
		                    	{!! Form::select('distributors', $distributors, null,['class' => 'form-control', 'id' => 'distributors', 'multiple' => 'multiple']) !!}
							</div>

				  		</div>

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('templates', 'Templates'); !!}
		                    	{!! Form::select('templates', $templates, null,['class' => 'form-control', 'id' => 'templates', 'multiple' => 'multiple']) !!}
							</div>

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

	$('#customers,#regions,#distributors,#templates').multiselect({
		maxHeight: 200,
		includeSelectAllOption: true,
		enableCaseInsensitiveFiltering: true,
		enableFiltering: true,
		buttonWidth: '100%',
		buttonClass: 'form-control'
	});

	

@endsection
