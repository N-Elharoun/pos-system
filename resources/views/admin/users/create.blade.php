@extends('admin.layouts.app',[
        'pageName' => 'Create User'
    ])
@section('content')
    <form action="{{ route('admin.users.store') }}" method="POST" >
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror"
                 name="username" id="username" value='{{ old('username') }}' 
                 placeholder="Enter Username">
                @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror " 
                 name="email" id="email" value='{{ old('email') }}'
                  placeholder="Enter email">
                   @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control  @error('full_name') is-invalid @enderror "
                 name="full_name" id="full_name" value='{{ old('full_name') }}' 
                 placeholder="Enter full name">
                @error('full_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
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
                <label for="confirm-password">Confirm Password</label>
                <input type="password" class="form-control  @error('password_confirmation"') is-invalid @enderror " 
                name="password_confirmation" id="confirm-password" 
                placeholder="Password">
                @error('password_confirmation"')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror            
            </div>
                <label class="form-check-label" for="active">Status</label>
                @foreach($userstatuses as $value =>$label)
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="{{ $label }}"
                         name="status" value='{{ $value }}' @if($loop->first) checked @endif >
                        <label class="form-check-label" for="{{ $label }}">{{ $label}}</label>
                    </div>
                @endforeach
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
@endsection