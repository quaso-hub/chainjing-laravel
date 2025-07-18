@extends('layouts.guest')

@section('content')
<div class="card card-round shadow">
    <div class="card-header text-center">
        <h4 class="card-title">{{ __('Register') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="nama">{{ __('Name') }}</label>
                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                       name="nama" value="{{ old('nama') }}" required autofocus>
                @error('nama') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
            </div>

            <div class="form-group mb-4">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-round">{{ __('Register') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
