@extends('admin.layouts.app',[
    'pageName'=>__('trans.edit_user')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.user_edit')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{  route('admin.users.update',$user->id) }} " id='main-form' method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="username" class="form-label">@lang('trans.username')</label>
                            <input type="text" name="username" value="{{ old('username',$user->username) }}"
                                class="form-control @error('username') is-invalid @enderror" id="username" required>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">@lang('trans.email')</label>
                            <input type="email" name="email" value="{{ old('email',$user->email) }}"
                            class="form-control @error('email') is-invalid @enderror " id="email" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="full_name" class="form-label">@lang('trans.full_name')</label>
                            <input type="text" name="full_name" value="{{ old('full_name',$user->full_name) }}"
                            class="form-control @error('full_name') is-invalid @enderror " id="full_name" required>
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
                            placeholder="Password">
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
                                    name="status" value='{{ $value }}' @if($user->status->value == $value) checked @endif >
                                    <label class="form-check-label" for="{{ $label }}">{{ $label}}</label>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <x-form-submit text="{{__('trans.update')}}"></x-form-submit>
                </div>
            </div>
        </div>
    </div>
@endsection
