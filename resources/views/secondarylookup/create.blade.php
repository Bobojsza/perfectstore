@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Secondary Display Lookup</h3>
				</div>
				{!! Form::open(array('route' => 'secondarylookup.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('store', 'Store'); !!}
	                    	{!! Form::select('store', $stores, null,['class' => 'form-control', 'id' => 'store']) !!}
						</div>

						@foreach($categories as $category)
						<div class="form-group">
					   		{!! Form::label(strtolower($category->category), $category->category); !!}
					   		@foreach($category->secondarybrand as $brand)
					   		<div class="checkbox">
		                      	<label>
		                      		{!! Form::checkbox('brands[]', $brand->id, false); !!} {{ $brand->brand }}
		                      	</label>
		                    </div>
					   		@endforeach
						</div>
						@endforeach
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('secondarylookup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>

				  	
				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
