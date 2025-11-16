@extends('admin.layouts.app',[
        'pageName' => __('trans.advanced_settings')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.advanced_settings')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.layouts.partials._flash')
                    <form action="{{ route('admin.settings.advanced.update')}}" id="main-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>@lang('trans.allow_decimal_quantities')</label>
                            <div>
                                <input type="radio" name="allow_decimal_quantities" id="allow" value= '1'
                                    {{ $settings->allow_decimal_quantities == '1' ? 'checked' : '' }}>
                                <label for="allow"> @lang('trans.allow')</label>
                            </div>
                            <div>
                                <input type="radio" id ="not_allow" name="allow_decimal_quantities" value="0"
                                    {{ $settings->allow_decimal_quantities == '0' ? 'checked' : '' }}>
                                <label for="not_allow"> @lang('trans.not_allow')</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('trans.discount_type')</label>
                            @foreach($settings->discount_type->labels() as $value => $label)
                                <div>
                                    <input type="radio" id ='discount.{{ $value }}' name="discount_type" value="{{ $value }}"
                                        {{ $settings->discount_type->value == $value ? 'checked' : '' }}>
                                    <label for ='discount.{{$value }}'>{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label>@lang('trans.payment_type')</label>
                            @foreach($paymentTypes as $value => $label)
                                <div>
                                    <input type="checkbox" id='payment.{{ $value}}' name="payment_type[]" value="{{ $value}}"
                                        {{ in_array($value, $selected) ? 'checked' : '' }}>
                                    <label for='payment.{{ $value}}'>{{ $label }}</label>
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
