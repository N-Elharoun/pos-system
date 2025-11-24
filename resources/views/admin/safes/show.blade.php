@extends('admin.layouts.app', [
    'pageName' => __('trans.safe_data'),
])

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
           <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>
                        <i class="fas fa-file-invoice me-2"></i>
                        @lang('trans.safe_data')
                    </h4>
                    <a href="{{ route('admin.safes.index') }}"
                    class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1 shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>@lang('trans.back_to_list')</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.layouts.partials._flash')
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>@lang('trans.name'):</strong>
                            <div class="text-muted">{{ $safe->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.description'):</strong>
                            <div class="text-muted">{{ $safe->description }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.balance'):</strong>
                            <div class="text-muted">{{ $safe->balance }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.type'):</strong>
                            <div class="badge bg-{{ $safe->type->style() }}">{{ $safe->type->label()}}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.status'):</strong>
                            <div class="badge bg-{{ $safe->status->style() }}">{{ $safe->status->label()}}</div>
                        </div>
                    </div>
                </div>
                <h5 class="text-secondary border-bottom pb-2 mb-3">
                    <i class="fas fa-boxes me-1"></i> @lang('trans.safe_transactions')
                </h5>
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">
                        <thead>
                             <tr>
                                <th>#</th>
                                <th>@lang('trans.date')</th>
                                <th>@lang('trans.transaction_type')</th>
                                <th>@lang('trans.amount')</th>
                                <th>@lang('trans.balance_after')</th>
                                <th>@lang('trans.description')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($safeTransactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->created_at->toDateString() }}</td>
                                    <td>
                                        <div class="badge bg-{{ $transaction->type->style() }}">
                                            {{ $transaction->type->label()}}
                                        </div>
                                    </td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->balance_after }}</td>
                                    <td>{{ $transaction->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                   <div class="card-footer clearfix">
                    {{ $safeTransactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
