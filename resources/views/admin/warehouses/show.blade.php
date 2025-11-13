@extends('admin.layouts.app', [
    'pageName' => __('trans.warehouse_data'),
])

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
           <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>
                        <i class="fas fa-file-invoice me-2"></i>
                        @lang('trans.warehouse_data')
                    </h4>
                    <a href="{{ route('admin.warehouses.index') }}"
                    class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1 shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>@lang('trans.back_to_list')</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.layouts.partials._flash')
                <div class="mb-4">
                    {{-- <h5 class="text-secondary border-bottom pb-2 mb-3">
                        <i class="fas fa-info-circle me-1"></i> @lang('trans.sale_information')
                    </h5> --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>@lang('trans.name'):</strong>
                            <div class="text-muted">{{ $warehouse->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.description'):</strong>
                            <div class="text-muted">{{ $warehouse->description }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.items'):</strong>
                            <div class="text-muted">{{ $warehouse->items ?  $warehouse->items->count() : 0  }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.status'):</strong>
                            <div class="badge bg-{{ $warehouse->status->style() }}">{{ $warehouse->status->label()}}</div>
                        </div>
                    </div>
                </div>
                <h5 class="text-secondary border-bottom pb-2 mb-3">
                    <i class="fas fa-boxes me-1"></i> @lang('trans.warehouse_transactions')
                </h5>
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">
                        <thead>
                             <tr>
                                <th>#</th>
                                <th>@lang('trans.date')</th>
                                <th>@lang('trans.item')</th>
                                <th>@lang('trans.quantity')</th>
                                <th>@lang('trans.quantity_after')</th>
                                <th>@lang('trans.transaction_type')</th>
                                <th>@lang('trans.description')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->created_at->toDateString() }}</td>
                                    <td>{{ $transaction->item->name}}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->quantity_after }}</td>
                                    <td>{{ $transaction->transaction_type->label() }}</td>
                                    <td>{{ $transaction->description }}</td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td colspan="2" class="text-end fw-bold">@lang('trans.total'):</td>
                                <td class="fw-bold">{{ (float) $transactions->sum('credit') }}</td>
                                <td class="fw-bold">{{ (float) $transactions->sum('debit') }}</td>
                                <td class="fw-bold">{{ $transactions->last()->balance_after ?? 0}}</td>
                                
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                   <div class="card-footer clearfix">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
