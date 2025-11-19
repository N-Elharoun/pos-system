@extends('admin.layouts.app',[
        'pageName' => __('trans.add_role')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.add_role')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.roles.store') }}" id="main-form" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('trans.name')</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" id="name" value='{{ old('name') }}'
                            placeholder="@lang('trans.enter_name')">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label  for="pemissions">@lang('trans.permissions')</label><br>
                            @foreach($permissions as $group => $groupPermissions)
                                <label cal>{{ $group }}</label>
                                <div class="row">
                                    @foreach($groupPermissions as $permission)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" id="{{ $permission->id }}"  value="{{ $permission->name }}" class="form-check-input">
                                                <label for="{{ $permission->id }}" class="form-check-label">{{ $permission->display_name ?? $permission->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <x-form-submit text="{{__('trans.create')}}"></x-form-submit>
                </div>
            </div>
        </div>
    </div>
@endsection
