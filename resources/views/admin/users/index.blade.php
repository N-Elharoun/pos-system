@extends('admin.layouts.app',[
    'pageName'=>'User Page',
    ])
@section('content')
    @if (session('add_user'))
        <div class="alert alert-success">
            {{ session('add_user') }}
        </div>
    @endif
     @if (session('update_user'))
        <div class="alert alert-success">
            {{ session('update_user') }}
        </div>
    @endif
    @if (session('delete_user'))
        <div class="alert alert-danger">
            {{ session('delete_user') }}
        </div>
    @endif
    <div class="row">
    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            Add New User
        </a>
    </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th style="width: 250px">Username</th>
                <th style="width: 350px">Email</th>
                <th style="width: 250px">FUll Name</th>
                <th>Status</th>
                <th>Action</th>
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
                            <a href="{{route('admin.users.show',$user->id)}}" class="btn btn-sm btn-info">View</a>
                            <a href="{{  route('admin.users.edit',$user->id) }}" class="btn btn-sm btn-info">Edit</a>
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
        <div class="mt-4"> 
            {{ $users->links() }}
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.delete-button').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "An error occurred while deleting the user.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush