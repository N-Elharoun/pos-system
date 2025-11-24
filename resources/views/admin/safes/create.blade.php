@extends('admin.layouts.app',[
        'pageName' => __('trans.add_safe')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.add_safe')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.safes.store') }}" id="main-form" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('trans.name')</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" id="name" value='{{ old('name') }}'
                            placeholder="@lang('trans.enter_name')">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('trans.description')</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                            name="description" id="description" value='{{ old('description') }}'
                            placeholder="@lang('trans.enter_description')">
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="balance">@lang('trans.balance')</label>
                            <input type="text" class="form-control @error('balance') is-invalid @enderror"
                            name="balance" id="balance" value='{{ old('balance') }}'
                            placeholder="@lang('trans.enter_balance')">
                            @error('balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label  for="type">@lang('trans.type')</label>
                            @foreach($safesTypes as $value =>$label)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="type-{{ $label }}"
                                    name="type" value='{{ $value }}' @if(old('type', $loop->first)) checked @endif >
                                    <label class="form-check-label" for="type-{{ $label }}">{{ $label}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label  for="status">@lang('trans.status')</label>
                            @foreach($safesStatuses as $value =>$label)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="status-{{ $label }}"
                                    name="status" value='{{ $value }}' @if(old('status', $loop->first)) checked @endif >
                                    <label class="form-check-label" for="status-{{ $label }}">{{ $label}}</label>
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
