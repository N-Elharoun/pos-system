@extends('admin.layouts.app',[
        'pageName' => __('trans.general_settings')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.general_settings')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.layouts.partials._flash')
                    <form action="{{ route('admin.settings.general.update')}}" id="main-form" method="POST"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="company_name">@lang('trans.company_name')</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                            name="company_name" id="company_name" value='{{ old('company_name', $settings->company_name) }}'>
                            @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company_email">@lang('trans.company_email')</label>
                            <input type="email" class="form-control @error('company_email') is-invalid @enderror"
                            name="company_email" id="company_email" value='{{ old('company_email', $settings->company_email) }}'>
                            @error('company_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company_phone">@lang('trans.company_phone')</label>
                            <input type="text" class="form-control @error('company_phone') is-invalid @enderror"
                            name="company_phone" id="company_phone" value='{{ old('company_phone', $settings->company_phone) }}'>
                            @error('company_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company_logo">@lang('trans.company_logo')</label>
                            <input type="file" class="form-control @error('company_logo') is-invalid @enderror"
                            name="company_logo" id="company_logo">
                            @error('company_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="col-12">
                                <img src="{{ asset('storage/' . $settings->company_logo ) }}" style="max-width: 100px; max-height: 100px;" class="product-image" alt="Logo">
                            </div>
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
