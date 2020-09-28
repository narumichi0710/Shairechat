@extends('layouts.app')
@section('content')

<div class="container mt-4">
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">{{ __('UserInfo') }}</div>
            <div class="list-group mb-3" style="max-width:800px; margin:auto;">
                <a href="{{ route('user.userEdit') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt>{{ __('Profile') }}</dt>
                        <dd class="mb-0">{{ $authUser->name}}</dd>
                    </dl>
                    <div><i class="fas fa-chevron-right"></i></div>
                </a>
                <a href="{{ route('user.userEditEmail') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt>{{ __('E-Mail Address') }}</dt>
                        <dd class="mb-0">{{ $authUser->email }}</dd>
                    </dl>
                    <div><i class="fas fa-chevron-right"></i></div>
                </a>
                <a href="{{ route('user.userEdit') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <dl class="mb-0">
                        <dt>{{ __('Change Password') }}</dt>
                        <dd class="mb-0">********</dd>
                    </dl>
                    <div><i class="fas fa-chevron-right"></i></div>
                </a>
            </div>
            <div class="list-group" style="max-width:400px; margin:auto;">
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>{{ __('Deactive') }}</div>
                    <div><i class="fas fa-chevron-right"></i></div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
