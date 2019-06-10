@extends('layouts.admin')
@section('title', @ucfirst(__('app.userMgmt')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 mb-3 font-weight-normal">
        <i class="fas fa-atlas" aria-hidden="true"></i> @ucfirst(__('app.userMgmt'))
    </h1>
</div>
@if ($errors->any())
<div class="row d-flex justify-content-center">
    <div class="col-6 mx-3 alert alert-danger">
        <ol>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
</div>
@endif
<div class="row d-flex justify-content-center">
    <div class="col-6">
        <form action="{{ route('user.update') }}" method="POST">
            {{ csrf_field() }}
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="input-uuid"><i class="fas fa-fingerprint" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="uuid" class="form-control" placeholder="@ucfirst(__('app.formUuid'))" value="{{ $user->uuid }}" aria-label="@ucfirst(__('app.formUuid'))" aria-describedby="input-uuid" readonly />
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="input-fname"><i class="fas fa-user" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="fname" class="form-control" placeholder="@ucfirst(__('auth.fname'))" value="{{ $user->fname }}" aria-label="@ucfirst(__('auth.fname'))" aria-describedby="input-fname" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="input-lname"><i class="fas fa-user-tie" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="lname" class="form-control" placeholder="@ucfirst(__('auth.lname'))" value="{{ $user->lname }}" aria-label="@ucfirst(__('auth.lname'))" aria-describedby="input-lname" />
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="input-username"><i class="fas fa-user-secret" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="username" class="form-control" placeholder="@ucfirst(__('auth.username'))" value="{{ $user->username }}" aria-label="@ucfirst(__('auth.username'))" aria-describedby="input-username" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="input-mail"><i class="fas fa-at" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="email" class="form-control" placeholder="@ucfirst(__('auth.email'))" value="{{ $user->email }}" aria-label="@ucfirst(__('auth.email'))" aria-describedby="input-mail" />
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="input-password1"><i class="fas fa-key" aria-hidden="true"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="@ucfirst(__('auth.password'))" aria-label="@ucfirst(__('auth.password'))" aria-describedby="input-password1" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="input-password2"><i class="fas fa-key" aria-hidden="true"></i></span>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="@ucfirst(__('auth.pwdConfirm'))" aria-label="@ucfirst(__('auth.pwdConfirm'))" aria-describedby="input-password2" />
                    </div>
                </div>
            </div>
            
            
            <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save" aria-hidden="true"></i> @ucfirst(__('app.save'))</button>
            </div>
        </form>
    </div>
</div>
@endsection