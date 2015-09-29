@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	{!! Form::open(array('route' => array('audittemplate.updateorder', $audittemplate->id),'method' => 'put')) !!}
	<div class="row menu pull-right">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-success">Update Order</button>
			{!! link_to_route('audittemplate.addform','Add Form',1,['class' => 'btn btn-primary']) !!}
			{!! link_to_route('audittemplate.index','Back',array(),['class' => 'btn btn-default']) !!}
		</div>
	</div>
	<div>
	@foreach($forms as $category)
	<div class="row sort-category">
		<div class="col-xs-12">
			<div class="box">
				
				<div class="box-header">
					<h3 class="box-title">{{ $category->category->category }}</h3>
					
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover" id="form_list">
						<thead>
							<tr>
								<th>Priority</th>
								<th>Group</th>
								<th>Type</th>
								<th>Prompt</th>
								<th>Expected Answer</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($category->groups as $group)
							<tr>
								<td>{{ $group->order }}</td>
								<td>{{ $group->form->group->group_desc }}</td>
								<td>{{ $group->form->type->form_type }}</td>
								<td>{{ $group->form->prompt}}</td>
								<td></td>
								<td></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div><!-- /.box-body -->

			</div><!-- /.box -->
		</div>
	</div>
	@endforeach
	</div>

	{!! Form::close() !!}
</section>

@endsection

@section('page-script')
//Helper function to keep table row from collapsing when being sorted
var fixHelperModified = function(e, tr) {
	var $originals = tr.children();
	var $helper = tr.clone();
	$helper.children().each(function(index){
		$(this).width($originals.eq(index).width());
	});
	return $helper;
}; 

//Make table sortable
$(".sort-category").sortable({
	/**helper: fixHelperModified,
	stop: function(event,ui) {
		renumber_table('#form_list');
	}**/
});

//Renumber table rows 
function renumber_table(tableID){
	$(tableID + " tr").each(function(){
		count = $(this).parent().children().index($(this)) + 1;
		<!-- $(this).find('.priority').html(count); -->
		$(this).find('.priority-hidden').val(count);
	}); 
} 
@endsection