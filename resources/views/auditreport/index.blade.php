@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Audit Report</h3>
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
                <th>User</th>
                <th>Store Code</th>
                <th>Store Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Passed</th>
                <th>Last Update</th>
                <th></th>
              </tr>
              @if (count($audits) > 0)
                @foreach($audits as $audit)
                <tr>
                  <td>{{ $audit->user_name }}</td>
                  <td>{{ $audit->store_code }}</td>
                  <td>{{ $audit->store_name }}</td>
                  <td>{{ $audit->start_date }}</td>
                  <td>{{ $audit->end_date }}</td>
                  <td>{{ $audit->passed }}</td>
                  <td>{{ $audit->updated_at }}</td>
                  <td></td>
                </tr>
                @endforeach
              @else
              <tr>
                <td colspan="7">No record found.</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
</section>

@endsection