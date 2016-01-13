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
                <th>Store</th>
                <th>Date Posted</th>
                <th>Area</th>
                <th>Action</th>
              </tr>
              @foreach($areas as $area)
              <tr>
                <td>{{ $area->id }}</td>
                <td>{{ $area->customer->account->account }}</td>
                <td>{{ $area->customer->customer }}</td>
                <td>{{ $area->area}}</td>
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