@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('store.create','New Store',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Store Lists</h3>
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
					<table id="store_table" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Account</th>
								<th>Customer</th>
								<th>Area</th>
								<th>Region</th>
								<th>Distributor</th>
								<th>Store</th>
								<th>Audit Template</th>
								<th>Grade Matrix</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($stores as $store)
							<tr>
								<td>{{ $store->id }}</td>
								<td>{{ $store->distributor->region->area->customer->account->account }}</td>
								<td>{{ $store->distributor->region->area->customer->customer }}</td>
								<td>{{ $store->distributor->region->area->area }}</td>
								<td>{{ $store->distributor->region->region }}</td>
								<td>{{ $store->distributor->distributor }}</td>
								<td>{{ $store->store }}</td>
								<td>{{ $store->store->audittemplate->template }}</td>
								<td>{{ $store->store->gradematrix->desc }}</td>
								<td></td>
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

@section('page-script')
	$('#store_table').DataTable();
@endsection
