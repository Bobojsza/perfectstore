@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Role</h3>
				</div>
				{!! Form::open(array('route' => 'role.store')) !!}
				  	<div class="box-body">

						<div class="form-group">
					   		{!! Form::label('name', 'Role Name'); !!}
	                    	{!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Role Name']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('display_name', 'Display Name'); !!}
	                    	{!! Form::text('display_name',null,['class' => 'form-control','placeholder' => 'Display Name']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('description', 'Description'); !!}
	                    	{!! Form::text('description',null,['class' => 'form-control','placeholder' => 'Description']) !!}
						</div>

				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('role.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

