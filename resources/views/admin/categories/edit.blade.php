@extends('admin.layouts.app',[
    'pageName'=>__('trans.edit_category')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.edit_category')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{  route('admin.categories.update',$category->id) }} " id ="main-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('trans.name')</label>
                            <input type="text" name="name" value="{{ old('name',$category->name) }}"
                            class="form-control @error('name') is-invalid @enderror" id="name" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="form-group">
                            <label for="photo">@lang('trans.photo')</label>
                            <input type="file" name="photo" id="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror" >
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if ($category->photo)
                                <div style="margin-top: 10px;">
                                    <strong>@lang('trans.photo'):</strong><br>
                                    <img src="{{ asset('storage/' . $category->photo->path) }}" alt="Current" width="150">
                                </div>
                            @endif
                        </div>
                        @foreach($categorystatuses as $value=>$label)
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="{{ $label }}"
                                    name="status" value='{{ $value }}' @if($category->status->value == $value) checked @endif >
                                <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
                            </div>
                        @endforeach
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
