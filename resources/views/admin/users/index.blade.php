@extends('admin.layouts.app',[
    'pageName'=>__('trans.users_page'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.users_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
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
                                <th style="width: 250px">@lang('trans.username')</th>
                                <th style="width: 350px">@lang('trans.email')</th>
                                <th style="width: 250px">@lang('trans.full_name')</th>
                                <th>@lang('trans.status')</th>
                                <th>@lang('trans.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->status->style() }}">{{ $user->status->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.users.show',$user->id)}}" class="btn btn-sm btn-info">@lang('trans.view')</a>
                                        <a href="{{  route('admin.users.edit',$user->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        @if(auth()->id() != $user->id)
                                            <a href="#"
                                                data-url="{{ route('admin.users.destroy', $user->id) }}"
                                                data-id="{{$user->id}}"
                                                class="btn btn-danger btn-sm delete-button">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <x-delete-button />
@endpush
