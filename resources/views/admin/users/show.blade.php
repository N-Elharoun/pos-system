@extends('admin.layouts.app',[
    'pageName'=> __('trans.show_user')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.user_show')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="container">
                        <div class="card shadow">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-3">@lang('trans.username'):</dt>
                                    <dd class="col-9">{{ $user->username }}</dd>

                                    <dt class="col-sm-3">@lang('trans.email'):</dt>
                                    <dd class="col-sm-9">{{ $user->email }}</dd>

                                    <dt class="col-sm-3">@lang('trans.full_name'):</dt>
                                    <dd class="col-sm-9">{{ $user->full_name}}</dd>
                                        <dt class="col-sm-3">@lang('trans.status')</dt>
                                        <dd class="col-sm-9">
                                            <span class="badge bg-{{ $user->status->style() }}">{{ $user->status->label() }}</span>
                                        </dd>
                                
                                </dl>
                                <a href=" {{ route('admin.users.edit',$user->id) }}" class="btn btn- btn-info">@lang('trans.edit')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
