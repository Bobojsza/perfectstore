@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	{!! Form::open(array('route' => array('audittemplate.updateorder', $audittemplate->id),'method' => 'put')) !!}
	<div class="row menu pull-right">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-success">Update Order</button>
			{!! link_to_route('audittemplate.addform','Add Form',$audittemplate->id,['class' => 'btn btn-primary']) !!}
			{!! link_to_route('audittemplate.index','Back',array(),['class' => 'btn btn-default']) !!}
		</div>
	</div>
	<div id="tempsort">
	@foreach($forms as $category)
	<div class="sortable">
		<div id="cat-{{$category->category_order}}" class="row cat-group">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"> {{$category->category_order }} - {{ $category->category->category }}</h3>
						{!! Form::hidden('c_id['.$category->category_order.']',$category->category_order,['class' => 'category-hidden']) !!}
					</div><!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover sort-group">
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
								<?php $cnt = 1;?>
								@foreach($category->groups as $group)
								<tr>
									<td class='priority'>
										{{ $cnt }}
										{!! Form::hidden('p_id['.$group ->id.']',$group->order,['class' => 'priority-hidden']) !!}
									</td>
									<td>{{ $group->group->group_desc }}</td>
									<td>{{ $group->form->type->form_type }}</td>
									<td>{{ $group->form->prompt}}</td>
									<td></td>
									<td></td>
								</tr>
								<?php $cnt++; ?>
								@endforeach
							</tbody>
						</table>
					</div><!-- /.box-body -->

				</div><!-- /.box -->
			</div>
		</div>
	</div>
	@endforeach
	</div>

	{!! Form::close() !!}
</section>

@endsection

@section('page-script')

var fixHelperModified2 = function(e, div) {
	var $originals = div.children();
	var $helper = div.clone();
	return $helper;
}; 

//Make table sortable
$("#tempsort").sortable({
	helper: fixHelperModified2,
	stop: function(event,ui) {
		renumber_category('#tempsort');
	}

});

function renumber_category(tableID){
	$(tableID + " .sortable").each(function(){
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.category-hidden').val(count);
		console.log($(this).find('.category-hidden'));
	}); 
} 



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
$(".sort-group tbody").sortable({
	helper: fixHelperModified,
	stop: function(event,ui) {
		renumber_table($(this).closest('.cat-group').attr('id'));
	}
});


//Renumber table rows 
function renumber_table(tableID){
	$("#"+tableID + " .sort-group tr").each(function(){
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.priority-hidden').val(count);
	}); 
} 
@endsection