@extends('admin.layouts.app', [
    'pageName' => __('trans.return_details'),
])

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
           <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>
                        <i class="fas fa-file-invoice me-2"></i>
                        @lang('trans.return_details')
                    </h4>
                    <a href="{{ route('admin.returns.index') }}"
                    class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1 shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>@lang('trans.back_to_list')</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.layouts.partials._flash')
                <div class="mb-4">
                    <h5 class="text-secondary border-bottom pb-2 mb-3">
                        <i class="fas fa-info-circle me-1"></i> @lang('trans.return_details')
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>@lang('trans.return_number'):</strong>
                            <div class="text-muted">{{ $return->invoice_number }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.total'):</strong>
                            <div class="fw-bold text-success">{{ $return->total }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.return_date'):</strong>
                            <div class="text-muted">{{ $return->sale_date }}</div>
                        </div>
                         <div class="col-md-6">
                            <strong>@lang('trans.discount'):</strong>
                            <div class="fw-bold text-danger">{{ $return->discount_value }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.user'):</strong>
                            <div class="text-muted">{{ $return->user->username }}</div>
                        </div>
                         <div class="col-md-6">
                            <strong>@lang('trans.net'):</strong>
                            <div class="fw-bold text-success">{{ $return->net_amount }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.client'):</strong>
                            <div class="text-muted">{{ $return->client->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.paid'):</strong>
                            <div class="fw-bold text-primary">{{ $return->paid_amount }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.safe'):</strong>
                            <div class="text-muted">{{ $return->safe->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.remaining'):</strong>
                            @if($return->remaining_amount > 0)
                                <div class="fw-bold text-danger">{{ $return->remaining_amount }}</div>
                            @else
                                <div class="text-muted">@lang('trans.fully_paid')</div>
                            @endif
                        </div>
                    </div>
                </div>
                <h5 class="text-secondary border-bottom pb-2 mb-3">
                    <i class="fas fa-boxes me-1"></i> @lang('trans.items')
                </h5>
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('trans.item_name')</th>
                                <th>@lang('trans.unit_price')</th>
                                <th>@lang('trans.quantity')</th>
                                <th>@lang('trans.total_price')</th>
                                <th>@lang('trans.warehouse')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($return->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td class="fw-bold text-success">{{ $item->pivot->total_price }}</td>
                                    <td>{{ $return->warehouse->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-4">
                    <span class="fw-bold">@lang('trans.total_items'):</span>
                    <span class="badge bg-info">{{ $return->items->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
