@extends('admin.layouts.app',[
    'pageName'=> __('trans.units_page')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.units_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.units.create') }}" class="btn btn-primary btn-sm">
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
                                <th >@lang('trans.status')</th>
                                <th>@lang('trans.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($units as $unit)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $unit->name}}</td>
                                    <td>
                                        <span class="badge bg-{{ $unit->status->style() }}">{{ $unit->status->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{  route('admin.units.edit',$unit->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        <a href="#"
                                            data-url="{{ route('admin.units.destroy', $unit->id) }}"
                                            data-id="{{$unit->id}}"
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
    <x-delete-button />
@endpush
