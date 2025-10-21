@extends('admin.layouts.app',[
    'pageName' => __('trans.categories_page'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.categories_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
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
                            <th style="width: 250px">@lang('trans.photo')</th>
                            <th style="width: 250px">@lang('trans.name')</th>
                            <th style="width: 350px">@lang('trans.items')</th>
                            <th>@lang('trans.status')</th>
                            <th>@lang('trans.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    @if ($category->photo)
                                        <td>
                                            <img src="{{ asset('storage/' . $category->photo->path) }}" alt="Current" width="150">
                                        </td>
                                    @else
                                        <td>
                                            @lang("trans.no_photo")
                                        </td>
                                    @endif
                                    <td>{{ $category->name }}</td>
                                    @if($category->items->count())
                                        <td>{{ $category->items->count()}} Items</td>
                                    @else
                                        <td>@lang('trans.no_items')</td>
                                    @endif
                                        <td>
                                        <span class="badge bg-{{ $category->status->style() }}">{{ $category->status->label() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{  route('admin.categories.edit',$category->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                            <a href="#"
                                                data-url="{{ route('admin.categories.destroy', $category->id) }}"
                                                data-id="{{$category->id}}"
                                                class="btn btn-danger btn-sm delete-button">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
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
                            Swal.fire("Error!", "An error occurred while deleting the category.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
