@extends('admin.layouts.app',[
    'pageName' => __('trans.edit_unit')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.edit_unit')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{  route('admin.units.update',$unit->id) }} "id="main-form"  method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="form-label">@lang('trans.name')</label>
                            <input type="text" name="name" value="{{ old('name',$unit->name) }}"
                            class="form-control @error('name') is-invalid @enderror" id="name" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label  for="status">@lang('trans.status')</label>
                            @foreach($unitstatuses as $value=>$label)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="{{ $label }}"
                                    name="status" value='{{ $value }}' @if($unit->status->value == $value) checked @endif >
                                    <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
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
