@extends('admin.layouts.app',[
    'pageName'=> __('trans.stocks'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.low_stock_items')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- @if($items->isEmpty())
                        <div class="alert alert-success">
                            @lang('trans.all_items_are_above_the_minimum_stock_level').
                        </div>
                    @endif --}}
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang('trans.name')</th>
                                <th>@lang('trans.item_code')</th>
                                <th>@lang('trans.current_stock')</th>
                                <th>@lang('trans.minimum_stock')</th>
                                <th>@lang('trans.category')</th>
                                <th>@lang('trans.unit')</th>
                                <th>@lang('trans.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->total_stock }}</td>
                                    <td>{{ $item->minimum_stock }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->unit->name }}</td>
                                    <td>
                                        @if($item->total_stock <= 0)
                                            <span class="badge bg-danger">@lang('trans.out_of_stock')</span>
                                        @elseif($item->total_stock <= $item->minimum_stock)
                                            <span class="badge bg-warning text-dark">@lang('trans.low_stock')</span>
                                        @else
                                            <span class="badge bg-success">@lang('trans.in_stock')</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>
    </div>
@endsection

