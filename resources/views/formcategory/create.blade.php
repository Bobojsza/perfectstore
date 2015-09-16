@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Category</h3>
				</div>
				{!! Form::open(array('route' => 'formcategory.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('category', 'Category Text'); !!}
	                    	{!! Form::text('category',null,['class' => 'form-control','placeholder' => 'Category Text']) !!}
						</div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
						{!! link_to_route('formcategory.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
