@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Template</h3>
				</div>
				{!! Form::open(array('route' => 'audittemplate.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('template', 'Template Text'); !!}
	                    	{!! Form::text('template',null,['class' => 'form-control','placeholder' => 'Template Text']) !!}
						</div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('audittemplate.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
