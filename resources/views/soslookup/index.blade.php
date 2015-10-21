@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('soslookup.create','New SOS Category Lookup',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">SOS Category Lookup</h3>
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
								<th>Customer</th>
								<th>Region</th>
								<th>Distributor</th>
								<th>Store</th>
								<th>Audit Template</th>
								<th>Action</th>
							</tr>
							@foreach($lookups as $lookup)
							<tr>
								<td>{{ $lookup->id }}</td>
								<td>
									@if(!empty($lookup->customer))
									{{ $lookup->customer->customer }}
									@else
									ALL
									@endif
								</td>

								<td>
									@if(!empty($lookup->region))
									{{ $lookup->region->region }}
									@else
									ALL
									@endif
								</td>

								<td>
									@if(!empty($lookup->distributor))
									{{ $lookup->distributor->distributor }}
									@else
									ALL
									@endif
								</td>


								<td>
									@if(!empty($lookup->store))
									{{ $lookup->store->store_code }} - {{ $lookup->store->store }}
									@else
									ALL
									@endif
								</td>

								<td>
									@if(!empty($lookup->template))
									{{ $lookup->template->template }}
									@else
									ALL
									@endif
								</td>

								<td>
									{!! link_to_action('SoslookupController@edit', 'Edit', $lookup->id, ['class' => 'btn btn-xs btn btn-primary']) !!}
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