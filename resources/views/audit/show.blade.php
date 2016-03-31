@extends('layouts.default')

@section('content')

@include('shared.notifications')
<div class="row">
    <div class="col-md-12">
      <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ url('audits/'.$audit->id.'/stores') }}" aria-expanded="true">Store Lists</a></li>
                <li class=""><a href="#tab_2" aria-expanded="false">Audit Templates</a></li>
                <li class=""><a href="#tab_3" aria-expanded="false">Tab 3</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="stores">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-header">
                                <h3 class="box-title">Store Lists</h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table id="store_table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Account</th>
                                            <th>Customer</th>
                                            <th>Region</th>
                                            <th>Distributor</th>
                                            <th>Store Code</th>
                                            <th>Store</th>
                                            <th>Grade Matrix</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($stores->count() > 0)
                                        @foreach($stores as $store)
                                        <tr>
                                            <td>{{ $store->account->account }}</td>
                                            <td>{{ $store->customer->customer }}</td>
                                            <td>{{ $store->region->region }}</td>
                                            <td>{{ $store->distributor->distributor }}</td>
                                            <td>{{ $store->store_code }}</td>
                                            <td>{{ $store->store }}</td>
                                            <td>{{ $store->gradematrix->desc }}</td>
                                            <td>{!! link_to_action('StoreController@edit', 'Edit', $store->id, ['class' => 'btn btn-xs btn btn-primary']) !!}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8">No record found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection