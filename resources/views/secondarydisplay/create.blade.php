@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Secondary Display</h3>
				</div>
				{!! Form::open(array('route' => 'secondarydisplay.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('category', 'Category'); !!}
	                    	{!! Form::select('category', $categories, null,['class' => 'form-control', 'id' => 'category']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('brand', 'Brand'); !!}
	                    	{!! Form::text('brand',null,['class' => 'form-control','placeholder' => 'Brand']) !!}
						</div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
						{!! link_to_route('secondarydisplay.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
