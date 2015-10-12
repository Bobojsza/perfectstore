@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
				  	<h3 class="box-title">New Store</h3>
				</div>
				{!! Form::open(array('route' => 'store.store')) !!}
				  	<div class="box-body">

				  		<div class="form-group">
							<label>Distributor</label>
							{!! Form::select('distributor', $distributors, null,['class' => 'form-control', 'id' => 'distributor']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('store_code', 'Store Code'); !!}
	                    	{!! Form::text('store_code',null,['class' => 'form-control','placeholder' => 'Store Code']) !!}
						</div>

						<div class="form-group">
					   		{!! Form::label('store', 'Store'); !!}
	                    	{!! Form::text('store',null,['class' => 'form-control','placeholder' => 'Store']) !!}
						</div>

						<div class="form-group">
							<label>Audit Template</label>
							{!! Form::select('template', $audittemplates, null,['class' => 'form-control', 'id' => 'template']) !!}
						</div>

						<div class="form-group">
							<label>Grade Matrix (Passing)</label>
							{!! Form::select('passing', $passings, null,['class' => 'form-control', 'id' => 'passing']) !!}
						</div>

						<table class="table table-bordered">
                    <tbody>
                    	<tr>
                      <th>Category</th>
                      @foreach($sostags as $tag)
                      <th>{{ $tag->sos_tag }}</th>
                      @endforeach
                    </tr>
                    	@foreach($categories as $category)
                    <tr>
                      	<td>{{ $category->category }}</td>
                      	@foreach($sostags as $tag)
                      	<td>
                      	 	<input type="radio" name="cat_{{ $category->id }}" id="{{ $category->id }}" value="{{ $tag->id}}" checked="">
		                </td>
                      	@endforeach
                      	
                    </tr>
                    @endforeach
                  </tbody></table>

						
				  	</div>

				 	<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('store.index','Back',array(),['class' => 'btn btn-default']) !!}
				  	</div>


				{!! Form::close() !!}
			  </div>
		</div>
	</div>
</section>
@endsection

