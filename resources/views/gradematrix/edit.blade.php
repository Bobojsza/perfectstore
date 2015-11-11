@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">Edit Grade Matrix</h3>
				</div>
				{!! Form::open(array('route' => array('gradematrix.update', $matrix->id),'method' => 'put')) !!}
				  	<div class="box-body">

						<div class="form-group">
					   		{!! Form::label('desc', 'Grade Matrix Description'); !!}
	                    	{!! Form::text('desc',$matrix->desc,['class' => 'form-control','placeholder' => 'Grade Matrix Description']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('passing', 'Passing'); !!}
	                    	{!! Form::text('passing',$matrix->passing,['class' => 'form-control','placeholder' => 'Passing']) !!}
						</div>
				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Update</button>
						{!! link_to_route('gradematrix.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

