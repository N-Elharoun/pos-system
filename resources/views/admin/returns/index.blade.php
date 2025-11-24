@extends('admin.layouts.app',[
    'pageName'=> __('trans.returns'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.returns_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.returns.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> @lang('trans.create')
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.layouts.partials._flash')
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>@lang('trans.return_number')</th>
                            <th>@lang('trans.return_date')</th>
                            <th>@lang('trans.client')</th>
                            <th>@lang('trans.total')</th>
                            <th>@lang('trans.paid')</th>
                            <th>@lang('trans.remaining')</th>
                            <th>@lang('trans.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if ($returns->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">@lang('trans.no_returns_found')</td>
                                </tr>
                            @endif
                            @foreach($returns as $return)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $return->invoice_number }}</td>
                                    <td>{{ $return->sale_date }}</td>
                                    <td>{{ $return->client->name }}</td>
                                    <td>{{ $return->net_amount }}</td>
                                    <td>{{ $return->paid_amount }}</td>
                                    <td>{{ $return->remaining_amount }}</td>
                                    <td>
                                        <a href="{{route('admin.returns.show',$return->id)}}" class="btn btn-sm btn-info">@lang('trans.view')</a>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $returns->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
