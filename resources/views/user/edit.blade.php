@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">Edit User</h3>
				</div>
				{!! Form::open(array('route' => array('user.update', $user->id),'method' => 'put')) !!}
				  	<div class="box-body">

						<div class="form-group">
					   		{!! Form::label('name', 'Full Name'); !!}
	                    	{!! Form::text('name',$user->name,['class' => 'form-control','placeholder' => 'Full Name']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('email', 'Email Address'); !!}
	                    	{!! Form::text('email',$user->email,['class' => 'form-control','placeholder' => 'Email Address']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('username', 'Username'); !!}
	                    	{!! Form::text('username',$user->username,['class' => 'form-control','placeholder' => 'Username']) !!}
						</div>
						
						<div class="form-group">
					   		{!! Form::label('role', 'Role'); !!}
					   		{!! Form::select('role', $roles, $user->roles[0]->id,['class' => 'form-control', 'id' => 'role']) !!}
						</div>

						<div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('active', 1,$user->active) !!} Active
		                  </label>
		                </div>

						
				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Update</button>
						{!! link_to_route('user.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

