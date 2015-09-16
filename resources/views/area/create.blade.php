@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Customer</h3>
				</div>
				{!! Form::open(array('route' => 'area.store')) !!}
				  	<div class="box-body">

				  		<div class="form-group">
							<label>Customer</label>
							{!! Form::select('customer', $customers, null,['class' => 'form-control', 'id' => 'customer']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('area', 'Area'); !!}
	                    	{!! Form::text('area',null,['class' => 'form-control','placeholder' => 'Area']) !!}
						</div>

				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('area.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

