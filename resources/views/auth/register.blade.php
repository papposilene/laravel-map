@extends('layouts.app')
@section('title', __('auth.register'))

@section('main')
<main role="main" class="container-fluid">
    <div class="row d-flex justify-content-center">
        <form class="col-md-6" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <h1 class="mb-3 font-weight-normal text-center">{{ __('auth.register') }}</h1>
            <div class="row form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="name" class="col-md-12 control-label">{{ __('auth.username') }}</label>
                <div class="col-md-12">
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus />
                    @if ($errors->has('username'))
                    <span class="help-block text-center text-danger">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">{{ __('auth.email') }}</label>
                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required />
                    @if ($errors->has('email'))
                    <span class="help-block text-center text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row form-group{{ $errors->has('password') ? ' has-error border-danger' : '' }}">
                <label for="password" class="col-md-12 control-label">{{ __('auth.password') }}</label>
                <div class="col-md-12">
                    <input id="password" type="password" class="form-control" name="password" required />
                    @if ($errors->has('password'))
                    <span class="help-block text-center text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row form-group">
                <label for="password-confirm" class="col-md-12 control-label">{{ __('auth.pwdConfirm') }}</label>
                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('auth.register') }}</button>
        </form>
        <div class="col-12 py-3 text-center">
            <a class="btn btn-link" href="{{ route('login') }}">{{ __('auth.signIn') }}</a>
        </div>
    </div>
</main>
@endsection