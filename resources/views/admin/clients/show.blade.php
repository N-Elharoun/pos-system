@extends('admin.layouts.app', [
    'pageName' => __('trans.client_data'),
])

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
           <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>
                        <i class="fas fa-file-invoice me-2"></i>
                        @lang('trans.client_data')
                    </h4>
                    <a href="{{ route('admin.clients.index') }}"
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
                            <div class="text-muted">{{ $client->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.email'):</strong>
                            <div class="text-muted">{{ $client->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.phone'):</strong>
                            <div class="text-muted">{{ $client->phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.address'):</strong>
                            <div class="text-muted">{{ $client->address }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.status'):</strong>
                            <div class="badge bg-{{ $client->status->style() }}">{{ $client->status->label()}}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.balance'):</strong>
                        @if($client->balance > 0)
                            <div class="fw-bold text-danger">{{ $client->balance }}</div>
                        @else
                            <div class="fw-bold text-success">{{ $client->balance }}</div>
                        @endif
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('trans.registered_via'):</strong>
                            <div class="badge bg-{{ $client->registered_via->style() }}">{{ $client->registered_via->label() }}</div>
                        </div>
                    </div>
                </div>
                <h5 class="text-secondary border-bottom pb-2 mb-3">
                    <i class="fas fa-boxes me-1"></i> @lang('trans.client_account_statement')
                </h5>
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('trans.date')</th>
                                <th>@lang('trans.credit')</th>
                                <th>@lang('trans.debit')</th>
                                <th>@lang('trans.balance')</th>
                                <th>@lang('trans.description')</th>
                                <th>@lang('trans.user')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->created_at->toDateString() }}</td>
                                    <td>{{ $transaction->credit }}</td>
                                    <td>{{ $transaction->debit }}</td>
                                    <td>{{ $transaction->balance_after }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->user->username }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-end fw-bold">@lang('trans.total'):</td>
                                <td class="fw-bold">{{ (float) $transactions->sum('credit') }}</td>
                                <td class="fw-bold">{{ (float) $transactions->sum('debit') }}</td>
                                <td class="fw-bold">{{ $transactions->last()->balance_after ?? 0}}</td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
