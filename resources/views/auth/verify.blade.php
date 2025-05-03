@extends('layouts.guest')

@section('content')
<div class="card card-round shadow">
    <div class="card-header text-center">
        <h4 class="card-title">{{ __('Verify Your Email Address') }}</h4>
    </div>
    <div class="card-body">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p class="mb-3">
            {{ __('Before proceeding, please check your email for a verification link.') }}<br>
            {{ __('If you did not receive the email') }},
        </p>

        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>.
        </form>
    </div>
</div>
@endsection
