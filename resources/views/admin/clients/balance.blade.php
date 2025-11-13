@extends('admin.layouts.app', [
    'pageName' => __('trans.debt_repayment')])

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom  py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-cash-register me-2"></i>
                        @lang('trans.debt_repayment')
                    </h5>
                    <a href="{{ route('admin.clients.index') }}"
                    class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1 shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>@lang('trans.back_to_list')</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.layouts.partials._flash')
                <div class="mb-3">
                    <h6 class="fw-bold">@lang('trans.client_name'):</h6>
                    <p class="text-muted">{{ $client->name }}</p>

                    <h6 class="fw-bold">@lang('trans.balance'):</h6>
                    <p class="text-danger fw-bold fs-5">{{ $client->balance }}</p>
                </div>

                <form action="{{ route('admin.clients.updateBalance', $client->id) }}" method="POST" id="main-form">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold">@lang('trans.amount_to_pay')</label>
                        <input type="number" step="0.01" name="amount" id="amount"
                        class="form-control @error('amount') is-invalid @enderror"
                        placeholder="@lang('trans.enter_payment_amount')"
                        required>

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
