@extends('layouts.default')

@section('content')

@include('shared.notifications')


<section class="content">
	{!! Form::open(array('route' => array('audittemplate.storeform', $audittemplate->id),'id' =>'addform')) !!}
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add Form to {{ $audittemplate->template }}</h3>
				</div>
				
					<div class="box-body">
						<div class="form-group">
							<label>Form Category</label>
							{!! Form::select('category', $formcategories, null,['class' => 'form-control', 'id' => 'category']) !!}
						</div>

						<div class="form-group">
							<label>Form Group</label>
							{!! Form::select('group', $formgroups, null,['class' => 'form-control', 'id' => 'group']) !!}
						</div>

					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						{!! link_to_route('audittemplate.form','Back',$audittemplate->id,['class' => 'btn btn-default']) !!}
					</div>
				
			  </div>
		</div>
	</div>

	<div class="row">
			<div class="col-xs-12">
			  <div class="box">
				<div class="box-header">
				  <h3 class="box-title">Hover Data Table</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
				  <table id="example" class="table table-bordered table-hover">
					<thead>
					  <tr>
					  	<th><input name="select_all" value="1" type="checkbox"></th>
						<th>Group</th>
						<th>Type</th>
						<th>Prompt</th>
					  </tr>
					</thead>
				  </table>
				</div><!-- /.box-body -->
			  </div><!-- /.box -->
			  
			</div><!-- /.col -->
		  </div>
	{!! Form::close() !!}
</section>
@endsection

@section('page-script')
//
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table){
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}

$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#example').DataTable({
   		"paging": false,
      'ajax': {
         'url': '{{ action('Api\FormsController@forms') }}' 
      },
      'columnDefs': [{
         'targets': 0,
         'data' : 'id',
         'searchable':false,
         'orderable':false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox">';
         }

      },{
         'targets': 1,
          'data' : 'group',
     	},{
         'targets': 2,
          'data' : 'type',
     	},{
         'targets': 3,
          'data' : 'prompt',
     	}],
      'order': [1, 'asc'],
      'rowCallback': function(row, data, dataIndex){
         // Get row ID
         var rowId = data.id;
         // If row ID is in the list of selected row IDs
         if($.inArray(rowId, rows_selected) !== -1){
            $(row).find('input[type="checkbox"]').prop('checked', true);
            $(row).addClass('selected');
         }
      }
   });

   // Handle click on checkbox
   $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data.id;

      // Determine whether row ID is in the list of selected row IDs 
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
         rows_selected.push(rowId);

      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
         rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });

   // Handle click on table cells with checkboxes
   $('#example').on('click', 'tbody td, thead th:first-child', function(e){
      $(this).parent().find('input[type="checkbox"]').trigger('click');
   });

   // Handle click on "Select all" control
   $('#example thead input[name="select_all"]').on('click', function(e){
      if(this.checked){
         $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
         $('#example tbody input[type="checkbox"]:checked').trigger('click');
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });

   // Handle table draw event
   table.on('draw', function(){
      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
   });

   // Handle form submission event 
   $('#addform').on('submit', function(e){
      var form = this;
      
      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         $(form).append(
             $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'forms_id[]')
                .val(rowId)
         );
      });
   });

});
       
@endsection