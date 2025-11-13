@extends('admin.layouts.app',[
    'pageName'=> __('trans.inventory_page')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.items_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.warehouses.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> @lang('trans.back_to_list')
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.layouts.partials._flash')
                    <form
                    action='{{ route('admin.warehouses.updateInventory',$warehouse->id)}}'
                    method = 'POST' id="main-form">
                        @csrf
                        @method('PUT')
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th >@lang('trans.name')</th>
                                    <th >@lang('trans.item_code')</th>
                                    <th style="width: 600px">@lang('trans.quantity')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($warehouse->items->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">@lang('trans.no_items_found')</td>
                                    </tr>
                                @endif
                                @foreach($warehouse->items as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $item->name}}</td>
                                        <td>{{ $item->item_code}}</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" step = '0.01'
                                                class="form-control @error('item.' . $item->id . '.quantity') is-invalid @enderror"
                                                name="items[{{$item->id}}][quantity]" id="quantity"
                                                value='{{ old('item.' . $item->id . '.quantity',$item->pivot->quantity) }}'>
                                                @error('item.' . $item->id . '.quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ 'Quantity must be at least 1' }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer clearfix">
                            <x-form-submit text="{{ __('trans.update') }}"></x-form-submit>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

