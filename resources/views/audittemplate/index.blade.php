@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	<div class="row menu pull-right">
		<div class="col-xs-12">
			{!! link_to_route('audittemplate.create','New Template',array(),['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Audit Template Lists</h3>
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
								<th>Template</th>
								<th colspan="2">Manage Forms</th>
							</tr>
							@foreach($templates as $template)
							<tr>
								<td>{{ $template->id }}</td>
								<td>{{ $template->template}}</td>
								<td>{!! link_to_action('AuditTemplateController@forms', 'Manage Form', $template->id, ['class' => 'btn btn-xs btn btn-primary']) !!}</td>
								<td>{!! link_to_action('AuditTemplateController@duplicate', 'Duplicate Form', $template->id, ['class' => 'btn btn-xs btn btn-primary']) !!}</td>
								<td>
									{!! Form::open(array('method' => 'DELETE', 'action' => array('AuditTemplateController@destroy', $template->id), 'class' => 'disable-button')) !!}                       
									{!! Form::submit('Delete', array('class'=> 'btn btn-danger btn-xs','onclick' => "if(!confirm('Are you sure to delete this record?')){return false;};")) !!}
									{!! Form::close() !!}
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