@extends('layouts.guest')

@section('content')
<div class="card card-round shadow">
    <div class="card-header text-center">
        <h4 class="card-title">{{ __('Reset Password') }}</h4>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group mb-4">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-round">{{ __('Send Password Reset Link') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
