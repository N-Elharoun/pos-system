@extends('admin.layouts.app',[
    'pageName'=> __('trans.roles_page')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.roles_list')</h3>
                    <div class="card-tools">
                        @can('create_role')
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
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
                                <th >@lang('trans.name')</th>
                                <th style="width:350px">@lang('trans.permissions')</th>
                                <th>@lang('trans.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $role->name}}</td>
                                    @if($role->permissions_count)
                                        <td>{{ $role->permissions_count }}</td>
                                    @else
                                        <td>@lang('trans.no_permissions')</td>
                                    @endif
                                    <td>
                                        @can('update_role')
                                        <a href="{{route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        @endcan
                                        @can('delete_role')
                                        <a href="#"
                                            data-url="{{route('admin.roles.destroy',$role->id) }}"
                                            data-id="{{$role->id}}"
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
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.layouts.partials._delete')
@endpush
