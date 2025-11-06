@extends('admin.layouts.app',[
    'pageName'=> __('trans.sales'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.sales_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm">
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
                            <th>@lang('trans.invoice_number')</th>
                            <th>@lang('trans.sale_date')</th>
                            <th>@lang('trans.client')</th>
                            <th>@lang('trans.total')</th>
                            <th>@lang('trans.paid')</th>
                            <th>@lang('trans.remaining')</th>
                            <th>@lang('trans.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if ($sales->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">@lang('trans.no_sales_found')</td>
                                </tr>
                            @endif
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $sale->invoice_number }}</td>
                                    <td>{{ $sale->sale_date }}</td>
                                    <td>{{ $sale->client->name }}</td>
                                    <td>{{ $sale->total }}</td>
                                    <td>{{ $sale->paid_amount }}</td>
                                    <td>{{ $sale->remaining_amount }}</td>
                                    <td>
                                        <a href="{{route('admin.sales.show',$sale->id)}}" class="btn btn-sm btn-info">@lang('trans.view')</a>
                                        @if ($sale->remaining_amount > 0)
                                            <a href="{{  route('admin.sales.edit',$sale->id) }}" class="btn btn-sm btn-warning">@lang('trans.pay')</a>
                                        @endif
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $sales->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
