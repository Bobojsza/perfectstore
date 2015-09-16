@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Region</h3>
				</div>
				{!! Form::open(array('route' => 'region.store')) !!}
				  	<div class="box-body">

				  		<div class="form-group">
							<label>Area</label>
							{!! Form::select('area', $areas, null,['class' => 'form-control', 'id' => 'area']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('region_code', 'Region Code'); !!}
	                    	{!! Form::text('region_code',null,['class' => 'form-control','placeholder' => 'Region Code']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('region', 'Region'); !!}
	                    	{!! Form::text('region',null,['class' => 'form-control','placeholder' => 'Region']) !!}
						</div>

				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('region.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

