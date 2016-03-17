@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">Edit Group</h3>
				</div>
				{!! Form::open(array('route' => array('formgroup.update', $formgroup->id),'method' => 'put')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('group_desc', 'Group Text'); !!}
	                    	{!! Form::text('group_desc',$formgroup->group_desc,['class' => 'form-control','placeholder' => 'Group Text']) !!}
						</div>

						<div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('secondary_display', 1, $formgroup->secondary_display) !!} Secondary Display Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('osa', 1, $formgroup->osa) !!} OSA Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('sos', 1, $formgroup->sos) !!} SOS Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('custom', 1, $formgroup->custom) !!} Customized Tag
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('perfect_store', 1, $formgroup->perfect_store) !!} Used on Perfect Store
		                  </label>
		                </div>
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Update</button>
						{!! link_to_route('formgroup.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection
