@extends('layouts.app')
@section('title', __('auth.signIn'))

@section('main')
<main role="main" class="container-fluid">
    <div class="row d-flex justify-content-center">
        <form class="col-md-6" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <h1 class="mb-3 font-weight-normal text-center">{{ __('auth.logPlease') }}</h1>
            <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-12 control-label">{{ __('auth.email') }}</label>
                <div class="col-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus />
                    @if ($errors->has('email'))
                    <span class="help-block mt-3 text-center text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-12 control-label">{{ __('auth.password') }}</label>
                <div class="col-12">
                    <input id="password" type="password" class="form-control" name="password" required />
                    @if ($errors->has('password'))
                    <span class="help-block mt-3 text-center text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row form-group">
                <div class="col-12 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('auth.rememberMe') }}
                        </label>
                    </div>
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('auth.signIn') }}</button>
        </form>
        <div class="col-12 py-3 text-center">
            <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('auth.pwdForget') }}</a>
            @if(Route::has('register'))
            <a class="btn btn-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
            @endif
        </div>
    </div>
</main>
@endsection
