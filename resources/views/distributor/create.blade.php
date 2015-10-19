@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New distributor</h3>
				</div>
				{!! Form::open(array('route' => 'distributor.store')) !!}
				  	<div class="box-body">
				  		
						<div class="form-group">
					   		{!! Form::label('distributor_code', 'Distributor Code'); !!}
	                    	{!! Form::text('distributor_code',null,['class' => 'form-control','placeholder' => 'Distributor Code']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('distributor', 'Distributor'); !!}
	                    	{!! Form::text('distributor',null,['class' => 'form-control','placeholder' => 'Distributor']) !!}
						</div>

				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('distributor.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

