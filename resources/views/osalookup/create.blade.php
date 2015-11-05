@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New OSA Category Lookup</h3>
				</div>
				{!! Form::open(array('route' => 'osalookup.store')) !!}
				  	<div class="box-body">

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('customer_id', 'Customer'); !!}
		                    	{!! Form::select('customer_id', array('0' => 'ALL CUSTOMER') +$customers, null,['class' => 'form-control', 'id' => 'customer_id']) !!}
							</div>

							<div class="form-group col-md-6">
						   		{!! Form::label('regions', 'Region'); !!}
		                    	{!! Form::select('regions', array('0' => 'ALL REGION') +$regions, null,['class' => 'form-control', 'id' => 'regions']) !!}
							</div>
				  		</div>

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('distributors', 'Distributor'); !!}
		                    	{!! Form::select('distributors', array('0' => 'ALL DISTRIBUTORS') +$distributors, null,['class' => 'form-control', 'id' => 'distributors']) !!}
							</div>

							<div class="form-group col-md-6">
						   		{!! Form::label('templates', 'Audit Template'); !!}
		                    	{!! Form::select('templates', array('0' => 'ALL AUDIT TEMPLATE') +$templates, null,['class' => 'form-control', 'id' => 'templates']) !!}
							</div>

							
				  		</div>
				  		
				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('store_id', 'Store'); !!}
		                    	{!! Form::select('store_id', array('0' => 'ALL STORES') +$stores, null,['class' => 'form-control', 'id' => 'store_id']) !!}
							</div>
				  		</div>

						
				  		<div class="row">
				  			<div class="form-group col-md-12">
								<table class="table table-bordered">
				                    <tbody>
				                    	<tr>
				                      <th>Category</th>
				                      <th>Target</th>
				                      <th>Total</th>
				                    </tr>
				                    @foreach($categories as $category)
				                    <tr>
				                      	<td>{{ $category->category }}</td>
				                      	<td>{!! Form::text('target['.$category->id.']',null,['class' => 'form-control','placeholder' => 'Target']) !!}</td>
				                      	<td>{!! Form::text('total['.$category->id.']',null,['class' => 'form-control','placeholder' => 'Total']) !!}</td>
				                    </tr>
				                    @endforeach
				                  	</tbody>
				              	</table>
							</div>
				  		</div>
						
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('osalookup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
