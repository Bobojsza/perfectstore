@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New SOS Category Lookup</h3>
				</div>
				{!! Form::open(array('route' => 'soslookup.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group col-md-6">
					   		{!! Form::label('customers', 'Customer'); !!}
	                    	{!! Form::select('customers', array('0' => 'ALL CUSTOMER') +$customers, null,['class' => 'form-control', 'id' => 'customers']) !!}
						</div>

						<div class="form-group col-md-6">
					   		{!! Form::label('regions', 'Region'); !!}
	                    	{!! Form::select('regions', array('0' => 'ALL REGION') +$regions, null,['class' => 'form-control', 'id' => 'regions']) !!}
						</div>

						<div class="form-group col-md-6">
					   		{!! Form::label('distributors', 'Distributor'); !!}
	                    	{!! Form::select('distributors', array('0' => 'ALL DISTRIBUTORS') +$distributors, null,['class' => 'form-control', 'id' => 'distributors']) !!}
						</div>

						<div class="form-group col-md-6">
					   		{!! Form::label('stores', 'Store'); !!}
	                    	{!! Form::select('stores', array('0' => 'ALL STORES') +$stores, null,['class' => 'form-control', 'id' => 'stores']) !!}
						</div>

						<div class="form-group col-md-6">
					   		{!! Form::label('templates', 'Audit Template'); !!}
	                    	{!! Form::select('teplates', array('0' => 'ALL AUDIT TEMPLATE') +$templates, null,['class' => 'form-control', 'id' => 'customer']) !!}
						</div>
						<div class="form-group col-md-12">
							<table class="table table-bordered">
			                    <tbody>
			                    	<tr>
			                      <th>Category</th>
			                      <th>Less</th>
			                      @foreach($sostags as $tag)
			                      <th>{{ $tag->sos_tag }}</th>
			                      @endforeach
			                    </tr>
			                    	@foreach($categories as $category)
			                    <tr>
			                      	<td>{{ $category->category }}</td>
			                      	<td>{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}</td>
			                      	@foreach($sostags as $tag)
			                      	<td>
									{!! Form::text('sos_tag',null,['class' => 'form-control','placeholder' => 'SOS Tag']) !!}
					                </td>
			                      	@endforeach
			                      	
			                    </tr>
			                    @endforeach
			                  	</tbody>
			              	</table>
						</div>


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
