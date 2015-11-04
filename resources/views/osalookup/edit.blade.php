@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">Edit OSA Category Lookup</h3>
				</div>
				{!! Form::open(array('route' => array('osalookup.update', $lookup->id),'method' => 'put')) !!}
				  	<div class="box-body">

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('customer_id', 'Customer'); !!}
		                    	{!! Form::select('customer_id', array('0' => 'ALL CUSTOMER') +$customers, $lookup->customer_id,['class' => 'form-control', 'id' => 'customer_id']) !!}
							</div>

							<div class="form-group col-md-6">
						   		{!! Form::label('regions', 'Region'); !!}
		                    	{!! Form::select('regions', array('0' => 'ALL REGION') +$regions, $lookup->region_id,['class' => 'form-control', 'id' => 'regions']) !!}
							</div>
				  		</div>

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('distributors', 'Distributor'); !!}
		                    	{!! Form::select('distributors', array('0' => 'ALL DISTRIBUTORS') +$distributors, $lookup->distributor_id,['class' => 'form-control', 'id' => 'distributors']) !!}
							</div>

							<div class="form-group col-md-6">
						   		{!! Form::label('templates', 'Audit Template'); !!}
		                    	{!! Form::select('templates', array('0' => 'ALL AUDIT TEMPLATE') +$templates, $lookup->template_id,['class' => 'form-control', 'id' => 'templates']) !!}
							</div>

							
				  		</div>
				  		
				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('stores', 'Store'); !!}
		                    	{!! Form::select('stores', array('0' => 'ALL STORES') +$stores, $lookup->store_id,['class' => 'form-control', 'id' => 'stores']) !!}
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
				                      	<td>{!! Form::text('target['.$category->id.']',isset($lookup->categories->where('category_id',$category->id)->first()->target) ? $lookup->categories->where('category_id',$category->id)->first()->target : "",['class' => 'form-control','placeholder' => 'Target']) !!}</td>
				                      	<td>{!! Form::text('total['.$category->id.']',isset($lookup->categories->where('category_id',$category->id)->first()->total) ? $lookup->categories->where('category_id',$category->id)->first()->total : "",['class' => 'form-control','placeholder' => 'Total']) !!}</td>
				                    </tr>
				                    @endforeach
				                  	</tbody>
				              	</table>
							</div>
				  		</div>
						
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Update</button>
						{!! link_to_route('osalookup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
