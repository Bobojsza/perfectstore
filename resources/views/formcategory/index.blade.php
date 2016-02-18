@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('formcategory.create','New Category',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Form Category Lists</h3>
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
								<th>Category</th>
								<th>With Secondary Display</th>
								<th>With On Stock Availibility</th>
								<th>With Share of Shelves</th>
								<th>With Customized SKU</th>
								<th>Used on Perfect Store</th>
								<th>Option</th>
							</tr>
							@foreach($formcategories as $category)
							<tr>
								<td>{{ $category->id }}</td>
								<td>{{ $category->category }}</td>
								<td>
									@if($category->secondary_display == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($category->osa_tagging == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($category->sos_tagging == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($category->custom == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>
									@if($category->perfect_store == 1)
									<i class="fa fa-fw fa-check"></i>
									@endif
								</td>
								<td>{!! link_to_action('FormCategoryController@edit', 'Edit', $category->id, ['class' => 'btn btn-xs btn btn-primary']) !!}</td>
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