	@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">
	{!! Form::open(array('route' => array('audittemplate.updateorder', $audittemplate->id),'method' => 'put')) !!}
	<h2 class="page-header-name">{{ $audittemplate->template }}</h2>
	<div class="row menu">
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
						<h3 class="box-title text-center">{{ $category->category->category }}</h3>
						{!! Form::hidden('c_id['.$category->id.']',$category->category_order,['class' => 'category-hidden']) !!}
						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			                <div class="btn-group">
			                  	<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"></button>
			                </div>
			            </div>
					</div><!-- /.box-header -->

					<div class="box-body table-responsive no-padding sort-group">
						@foreach($category->groups()->orderBy('group_order')->get() as $group)
						<div class="box">
							<div class="box-header">
								<h2 class="box-title"> {{ $group->group->group_desc }}</h2>
								{!! Form::hidden('g_id['.$group ->id.']',$group->group_order,['class' => 'group-hidden']) !!}
								<div class="box-tools pull-right">
					                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					                <div class="btn-group">
					                  	<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"></button>
					                </div>
					             </div>
							</div><!-- /.box-header -->
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover sort-form">
									<thead>
										<tr>
											<th>Type</th>
											<th>Prompt</th>
											<th>Expected Answer</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($group->forms()->orderBy('order')->get() as $form)
										<tr>
											<td>
												{{ $form->form->type->form_type }}
												{!! Form::hidden('f_id['.$form->id.']',$form->order,['class' => 'form-hidden']) !!}
											</td>
											<td>{{ $form->form->prompt }}</td>
											<td></td>
											<td></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	</div>

	{!! Form::close() !!}
</section>

@endsection

@section('page-script')

//Make category sortable

var fixCategory = function(e, div) {
	var $originals = div.children();
	var $helper = div.clone();
	return $helper;
}; 
$("#tempsort").sortable({
	helper: fixCategory,
	stop: function(event,ui) {
		renumber_category('#tempsort');
	}

});

function renumber_category(tableID){
	$(tableID + " .sortable").each(function(){
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.category-hidden').val(count);
	}); 
} 



//Make group sortable
var fixGroup = function(e, div) {
	var $originals = div.children();
	var $helper = div.clone();
	return $helper;
}; 

$(".sort-group").sortable({
	helper: fixGroup,
	stop: function(event,ui) {
		renumber_group();
	}
});

function renumber_group(tableID){
	$(".box").each(function(){
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.group-hidden').val(count);
	});
} 

//Make form sortable
var fixForm = function(e, tr) {
	var $originals = tr.children();
	var $helper = tr.clone();
	$helper.children().each(function(index){
		$(this).width($originals.eq(index).width());
	});
	return $helper;
}; 

$(".sort-form tbody").sortable({
	helper: fixForm,
	stop: function(event,ui) {
		renumber_form($(this).closest('.cat-group').attr('id'));
	}
});

function renumber_form(tableID){
	$("#"+tableID + " .sort-form tr").each(function(){
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.form-hidden').val(count);
	}); 
} 
@endsection