@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">Edit Category</h3>
				</div>
				{!! Form::open(array('route' => array('formcategory.update', $category->id),'method' => 'put')) !!}
				  	<div class="box-body">
				  		<div class="form-group">
					   		{!! Form::label('category', 'Category Text'); !!}
	                    	{!! Form::text('category',$category->category,['class' => 'form-control','placeholder' => 'Category Text']) !!}
						</div>

						<div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('secondary_display',1, $category->secondary_display) !!} With Secondary Display
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('osa_tagging',1, $category->osa_tagging) !!} With On Stock Availibility
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('sos_tagging',1, $category->sos_tagging) !!} With Share of Shelves
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('custom',1, $category->custom) !!} With Customized SKU
		                  </label>
		                </div>

		                <div class="checkbox">
		                  <label>
		                  	{!! Form::checkbox('perfect_store',1, $category->perfect_store) !!} Used on Perfect Store
		                  </label>
		                </div>
		                
				  	</div><!-- /.box-body -->

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Update</button>
						{!! link_to_route('formcategory.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection


