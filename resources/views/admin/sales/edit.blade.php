@extends('admin.layouts.app', ['pageName' => __('trans.pay_sale')])

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-cash-register me-2"></i> @lang('trans.pay_sale')
                </h5>
                <a href="{{ route('admin.sales.show', $sale->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> @lang('trans.back')
                </a>
            </div>

            <div class="card-body">
                @include('admin.layouts.partials._flash')
                <div class="mb-3">
                    <h6 class="fw-bold">@lang('trans.invoice_number'):</h6>
                    <p class="text-muted">{{ $sale->invoice_number }}</p>

                    <h6 class="fw-bold">@lang('trans.client'):</h6>
                    <p class="text-muted">{{ $sale->client->name }}</p>

                    <h6 class="fw-bold">@lang('trans.remaining_amount'):</h6>
                    <p class="text-danger fw-bold fs-5">{{ $sale->remaining_amount }}</p>
                </div>

                <form action="{{ route('admin.sales.update', $sale->id) }}" method="POST" id="main-form">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold">@lang('trans.amount_to_pay')</label>
                        <input type="number" step="0.01" name="amount" id="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               placeholder="@lang('trans.enter_payment_amount')"
                               max="{{ $sale->remaining_amount }}" required>

                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-form-submit text="{{__('trans.confirm_payment')}}"></x-form-submit>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
