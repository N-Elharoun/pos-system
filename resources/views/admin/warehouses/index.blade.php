@extends('admin.layouts.app',[
    'pageName'=> __('trans.warehouses_page')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.warehouses_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary btn-sm">
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
                                <th >@lang('trans.name')</th>
                                <th >@lang('trans.description')</th>
                                <th >@lang('trans.items')</th>
                                <th >@lang('trans.status')</th>
                                <th>@lang('trans.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($warehouses as $warehouse)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $warehouse->name}}</td>
                                    <td>{{ $warehouse->description}}</td>
                                    <td>{{ $warehouse->items_count }}</td>
                                    <td>
                                        <span class="badge bg-{{ $warehouse->status->style() }}">{{ $warehouse->status->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{  route('admin.warehouses.show',$warehouse->id) }}" class="btn btn-sm btn-info">@lang('trans.show')</a>
                                        <a href="{{  route('admin.warehouses.edit',$warehouse->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        <a href="{{  route('admin.warehouses.inventory',$warehouse->id) }}" class="btn btn-sm btn-info">@lang('trans.inventory')</a>
                                        <a href="#"
                                            data-url="{{ route('admin.warehouses.destroy', $warehouse->id) }}"
                                            data-id="{{$warehouse ->id}}"
                                            class="btn btn-danger btn-sm delete-button">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.layouts.partials._delete')
@endpush
