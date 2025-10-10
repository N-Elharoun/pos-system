@extends('admin.layouts.app',[
        'pageName' => __('trans.edit_client')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.edit_client')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.clients.update',$client->id) }}" id="main-form" method="POST" >
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">@lang('trans.name')</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" id="name" value='{{ old('name', $client->name) }}'
                            placeholder="@lang('trans.enter_name')">
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">@lang('trans.email')</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror "
                            name="email" id="email" value='{{ old('email',$client->email) }}'
                            placeholder="@lang('trans.enter_email')">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">@lang('trans.phone')</label>
                            <input type="text" class="form-control  @error('phone') is-invalid @enderror "
                            name="phone" id="phone" value="{{ old('phone',$client->phone) }}"
                            placeholder="@lang('trans.enter_phone')">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">@lang('trans.address')</label>
                            <input type="text" class="form-control  @error('address') is-invalid @enderror "
                            name="address" id="address" value ="{{ old('address',$client->address) }}"
                            placeholder="@lang('trans.enter_address')">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="balance">@lang('trans.balance')</label>
                            <input type="text" class="form-control  @error('balance') is-invalid @enderror "
                            name="balance" id="balance" value="{{ old('balance',$client->balance) }}"
                            placeholder="@lang('trans.enter_balance')">
                            @error('balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for='status'>@lang('trans.status')</label>
                            @foreach($clientStatus as $value =>$label)
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="{{ $label }}"
                                    name="status" value='{{ $value }} ' @if($client->status->value == $value) checked @endif >
                                    <label class="form-check-label" for="{{ $label }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                           <div class="form-group">
                                <label for='register_from' >@lang('trans.registered_via')</label>
                                @foreach($clientRegistration as $value =>$label)
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="{{ $label }}"
                                        name="registered_via" value='{{ $value }}' @if($client->registered_via->value ==  $value) checked @endif>
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
