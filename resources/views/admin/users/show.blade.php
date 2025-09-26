@extends('admin.layouts.app',[
    'pageName'=>'Show User'
    ])

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">User Details</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Username:</dt>
                <dd class="col-sm-9">{{ $user->username }}</dd>

                <dt class="col-sm-3">Email Address:</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">Full Name:</dt>
                <dd class="col-sm-9">{{ $user->full_name}}</dd>
                    <dt class="col-sm-3">Status:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $user->status->style() }}">{{ $user->status->label() }}</span>
                    </dd>
               
            </dl>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
            <a href=" {{ route('admin.users.edit',$user->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection