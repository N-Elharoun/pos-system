@extends('admin.layouts.app',[
    'pageName'=> __('trans.safes_page')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.safes_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.safes.create') }}" class="btn btn-primary btn-sm">
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
                                <th >@lang('trans.balance')</th>
                                <th >@lang('trans.type')</th>
                                <th >@lang('trans.status')</th>
                                <th>@lang('trans.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($safes as $safe)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $safe->name}}</td>
                                    <td>{{ $safe->description ?? 'no description'}}</td>
                                    <td>{{ $safe->balance}}</td>
                                    <td>
                                        <span class="badge bg-{{ $safe->type->style() }}">{{ $safe->type->label() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $safe->status->style() }}">{{ $safe->status->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{  route('admin.safes.show',$safe->id) }}" class="btn btn-sm btn-info">@lang('trans.show')</a>
                                        <a href="{{  route('admin.safes.edit',$safe->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        <a href="#"
                                            data-url="{{ route('admin.safes.destroy', $safe->id) }}"
                                            data-id="{{$safe->id}}"
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
