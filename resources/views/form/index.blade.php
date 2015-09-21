@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('form.create','New Form',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Form Lists</h3>
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
								<th>Group</th>
								<th>Type</th>
								<th>Prompt</th>
								<th>Required</th>
								<th>With Answer</th>
								<th>Exempted</th>
								<th>Action</th>
							</tr>
							@foreach($forms as $form)
							<tr>
								<td>{{ $form->id }}</td>
								<td>{{ $form->group->group_desc }}</td>
								<td>{{ $form->type->form_type }}</td>
								<td>{{ $form->prompt }}</td>
								<td>{{ (($form->required == 1) ? 'True':'False') }}</td>
								<td>{{ (($form->expected_answer == 1) ? 'True':'False') }}</td>
								<td>{{ (($form->exempt == 1) ? 'True':'False') }}</td>
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