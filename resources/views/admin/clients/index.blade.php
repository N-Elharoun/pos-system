@extends('admin.layouts.app',[
    'pageName'=>__('trans.clients_page'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.clients_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm">
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
                                <th>@lang('trans.name')</th>
                                <th>@lang('trans.email')</th>
                                <th>@lang('trans.phone')</th>
                                <th>@lang('trans.address')</th>
                                <th>@lang('trans.balance')</th>
                                <th>@lang('trans.status')</th>
                                <th style="width: 10px">@lang('trans.registered_via')</th>
                                <th style="width: 150px">@lang('trans.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->balance }}</td>
                                    <td>
                                        <span class="badge bg-{{ $client->status->style() }}">{{ $client->status->label() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $client->registered_via->style() }}">{{ $client->registered_via->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{  route('admin.clients.edit',$client->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                        <a href="#"
                                            data-url="{{ route('admin.clients.destroy', $client->id) }}"
                                            data-id="{{$client->id}}"
                                            class="btn btn-danger btn-sm delete-button">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
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
