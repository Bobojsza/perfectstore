@extends('layouts.default')

@section('content')

@include('shared.notifications')

<section class="content">

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">User Detailed Report</h3>
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
                <th>Store Code</th>
                <th>Store Name</th>
                <th>Last Update</th>
                <th>Perfect Store</th>
                <th >Action</th>
              </tr>
              @if (count($stores) > 0)
                @foreach($stores as $store)
                <tr>
                  <td>{{ $store->store_code }}</td>
                  <td>{{ $store->store_name }}</td>
                  <td>{{ $store->updated_at }}</td>
                  <td>{{ $store->passed }}</td>
                 <td>
                    {!! link_to_action('UserReportController@storesummary', 'Audit Summary', $store->id, ['class' => 'btn btn-xs btn btn-primary']) !!}
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