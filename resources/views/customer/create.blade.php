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
				{!! Form::open(array('route' => 'customer.store')) !!}
				  	<div class="box-body">

				  		<div class="form-group">
							<label>Account</label>
							{!! Form::select('account', $accounts, null,['class' => 'form-control', 'id' => 'account']) !!}
						</div>

				  		<div class="form-group">
					   		{!! Form::label('customer_code', 'Customer Code'); !!}
	                    	{!! Form::text('customer_code',null,['class' => 'form-control','placeholder' => 'Customer Code']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('customer', 'Customer'); !!}
	                    	{!! Form::text('customer',null,['class' => 'form-control','placeholder' => 'Customer']) !!}
						</div>

				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('customer.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

