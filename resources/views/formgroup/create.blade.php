@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Group</h3>
				</div>
				{!! Form::open(array('route' => 'formgroup.store')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('group_desc', 'Group Text'); !!}
	                    	{!! Form::text('group_desc',null,['class' => 'form-control','placeholder' => 'Group Text']) !!}
						</div>

						<div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('secondary_display', 1) !!} Secondary Display Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('osa', 1) !!} OSA Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('sos', 1) !!} SOS Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('custom', 1) !!} Customized Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('perfect_store', 1) !!} Used on Perfect Store
		                  </label>
		                </div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('formgroup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
