@extends('admin.layouts.app',[
    'pageName'=> __('trans.items'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.items_list')</h3>
                    <div class="card-tools">
                        @can('create_item')
                        <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> @lang('trans.create')
                        </a>
                        @endcan
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.layouts.partials._flash')
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th >@lang('trans.photo')</th>
                            <th style="width: 50px">@lang('trans.name')</th>
                            <th>@lang('trans.item_code')</th>
                            <th style="width: 150px">@lang('trans.description')</th>
                            <th>@lang('trans.price')</th>
                            <th style="width: 10px">@lang('trans.quantity')</th>
                            <th style="width: 10px">@lang('trans.m.stock')</th>
                            <th style="width: 50px">@lang('trans.category')</th>
                            <th>@lang('trans.unit')</th>
                            <th style="width: 10px">@lang('trans.status')</th>
                            <th style="width: 10px">@lang('trans.show_in_store')</th>
                            <th>@lang('trans.action')</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    @if ($item->photo)
                                        <td>
                                            <img src="{{ asset('storage/' . $item->photo->path) }}" alt="Current" width="50">
                                        </td>
                                    @else
                                        <td>
                                            @lang("trans.no_photo")
                                        </td>
                                    @endif
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->item_code}}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->price }}</td>
                                    @if ($item->warehouses->count())
                                        <td>{{ $item->warehouses->sum('pivot.quantity') }}</td>
                                    @else
                                        <td>0</td>
                                    @endif
                                    <td>{{ $item->minimum_stock}}</td>
                                    <td>{{ $item->category?->name  ?? 'no category' }}</td>
                                    <td>{{ $item->unit?->name ??  'no unit'}}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status->style() }}">
                                            {{ $item->status->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->is_shown_in_store->style() }}">
                                            {{ $item->is_shown_in_store->label() }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.items.show',$item->id)}}" class="btn btn-sm btn-info">@lang('trans.view')</a>
                                        @can('update_item')
                                        <a href="{{  route('admin.items.edit',$item->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        @endcan
                                        @can('delete_item')
                                        <a href="#"
                                            data-url="{{ route('admin.items.destroy', $item->id) }}"
                                            data-id="{{$item->id}}"
                                            class="btn btn-danger btn-sm delete-button">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $items->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
@push('js')
    @include('admin.layouts.partials._delete')
@endpush
