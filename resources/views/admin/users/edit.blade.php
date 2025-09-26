@extends('admin.layouts.app',[
    'pageName'=>'Edit User'
    ])
@section('content')
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{  route('admin.users.update',$user->id) }} " method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" value="{{ old('username',$user->username) }}"
                                 class="form-control @error('username') is-invalid @enderror" id="username" required>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email',$user->email) }}" 
                                class="form-control @error('email') is-invalid @enderror " id="email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full name</label>
                                <input type="text" name="full_name" value="{{ old('full_name',$user->full_name) }}" 
                                class="form-control @error('full_name') is-invalid @enderror " id="full_name" required>
                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @foreach($userstatuses as $value=>$label)
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="{{ $label }}"
                                 name="status" value='{{ $value }}' @if($user->status->value == $value) checked @endif >
                                <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
                            </div>
                            @endforeach 
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection