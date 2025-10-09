@extends('admin.layouts.app',[
        'pageName' => __('trans.create_user')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.create_user')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" id="main-form" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="username">@lang('trans.username')</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" id="username" value='{{ old('username') }}'
                            placeholder="@lang('trans.enter_username')">
                            @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">@lang('trans.email')</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror "
                            name="email" id="email" value='{{ old('email') }}'
                            placeholder="@lang('trans.enter_email')">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="full_name">@lang('trans.full_name')</label>
                            <input type="text" class="form-control  @error('full_name') is-invalid @enderror "
                            name="full_name" id="full_name" value='{{ old('full_name') }}'
                            placeholder="@lang('trans.enter_full_name')">
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('trans.password')</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror "
                            name="password" id="password"
                            placeholder="@lang('trans.enter_password')">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">@lang('trans.confirm_password')</label>
                            <input type="password" class="form-control  @error('password_confirmation"') is-invalid @enderror "
                            name="password_confirmation" id="confirm-password"
                            placeholder="@lang('trans.enter_confirm_password')">
                            @error('password_confirmation"')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="active">@lang('trans.status')</label>
                            @foreach($userstatuses as $value =>$label)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="{{ $label }}"
                                    name="status" value='{{ $value }}' @if($loop->first) checked @endif >
                                    <label class="form-check-label" for="{{ $label }}">{{ $label}}</label>
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
