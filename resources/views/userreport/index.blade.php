@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">User Summary Report</h3>
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
                <th>Start Date</th>
                <th>End Date</th>
                <th>Stores Mapped</th>
                <th>Stores Visited</th>
                <th>Perpect Stores</th>
                <th>To Be Visited</th>
                <th >Action</th>
              </tr>
              @if (count($users) > 0)
                @foreach($users as $user)
                <tr>
                  <td>{{ $user->user_name }}</td>
                  <td>{{ $user->start_date }}</td>
                  <td>{{ $user->end_date }}</td>
                  <td>{{ $user->mapped_stores }}</td>
                  <td>{{ $user->store_visited }}</td>
                  <td>{{ $user->perfect_stores }}</td>
                  <td>{{ $user->pending_stores }}</td>
                 <td>
                    {!! link_to_action('UserReportController@details', 'Store List', $user->id, ['class' => 'btn btn-xs btn btn-primary']) !!}
                  </td>

                </tr>
                @endforeach
              @else
              <tr>
                <td colspan="8">No record found.</td>
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