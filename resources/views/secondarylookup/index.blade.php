@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('secondarylookup.create','New Secondary Display Lookup',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Secondary Display Lookup Lists</h3>
					<div class="box-tools">
						<div class="input-group" style="width: 150px;">
							<input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
							<div class="input-group-btn">
								<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
							<tr>
								<th>ID</th>
								<th>Store Code</th>
								<th>Store</th>
								<th>Option</th>
							</tr>
							@foreach($stores as $store)
							<tr>
								<td>{{ $store->id }}</td>
								<td>{{ $store->store_code }}</td>
								<td>{{ $store->store }}</td>
								<td>
									<td>{!! link_to_action('SecondarylookupController@edit', 'View', $store->id, ['class' => 'btn btn-xs btn btn-primary']) !!}</td>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section>

@endsection