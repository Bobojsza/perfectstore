@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New SOS Category Lookup</h3>
				</div>
				{!! Form::open(array('route' => 'soslookup.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('customers', 'Customer'); !!}
	                    	{!! Form::select('customers', array('0' => 'ALL CUSTOMER') +$customers, null,['class' => 'form-control', 'id' => 'customer']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('regions', 'Region'); !!}
	                    	{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('distributors', 'Distributor'); !!}
	                    	{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('stores', 'Store'); !!}
	                    	{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('templates', 'Audit Template'); !!}
	                    	{!! Form::select('teplates', array('0' => 'ALL AUDIT TEMPLATE') +$templates, null,['class' => 'form-control', 'id' => 'customer']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('category', 'Category'); !!}
	                    	{!! Form::select('category', $categories, null,['class' => 'form-control', 'id' => 'customer']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('less', 'Less'); !!}
	                    	{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}
						</div>

						<table class="table table-bordered">
		                    <tbody>
		                    	@foreach($sostags as $tag)
		                    <tr>
		                      	<td>{{ $tag->sos_tag }}</td>
		                      	<td>
		                      	 	{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'Passing Percentage']) !!}
				                </td>
		                      	
		                    </tr>
		                    @endforeach
		                  </tbody>
		              </table>


				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('soslookup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
