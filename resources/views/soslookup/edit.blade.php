@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">Edit SOS Category Lookup</h3>
				</div>
				{!! Form::open(array('route' => array('soslookup.update', $lookup->id),'method' => 'put')) !!}
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
						   		{!! Form::label('stores', 'Store'); !!}
		                    	{!! Form::select('stores', array('0' => 'ALL STORES') +$stores, $lookup->store_id,['class' => 'form-control', 'id' => 'stores']) !!}
							</div>
				  		</div>

				  		<div class="row">
				  			<div class="form-group col-md-6">
						   		{!! Form::label('templates', 'Audit Template'); !!}
		                    	{!! Form::select('templates', array('0' => 'ALL AUDIT TEMPLATE') +$templates,  $lookup->template_id,['class' => 'form-control', 'id' => 'templates']) !!}
							</div>
				  		</div>
				  		
				  		<div class="row">
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
				                      	<td>{!! Form::text('category['.$category->id.'][0]',isset($lookup->categories->where('category_id',$category->id)->first()->less) ? $lookup->categories->where('category_id',$category->id)->first()->less : "" ,['class' => 'form-control numeric_input','placeholder' => 'Less']) !!}</td>
				                      	@foreach($sostags as $tag)
				                      	<td>
				                      		{!! Form::text('category['.$category->id.']['.$tag->id.']',isset($lookup->categories->where('category_id',$category->id)->where('sos_id',$tag->id)->first()->value) ? $lookup->categories->where('category_id',$category->id)->where('sos_id',$tag->id)->first()->value : "",['class' => 'form-control numeric_input','placeholder' => $tag->sos_tag]) !!}
						                </td>
				                      	@endforeach
				                      	
				                    </tr>
				                    @endforeach
				                  	</tbody>
				              	</table>
							</div>
				  		</div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Update</button>
						{!! link_to_route('soslookup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

@section('page-script')
$("input.numeric_input").numeric_input({
	decimal: '.',
	leadingZeroCheck: true
});
@endsection
