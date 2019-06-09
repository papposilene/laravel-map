@extends('layouts.admin')
@section('title', @ucfirst(__('app.editCat')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3">
        <i class="fas fa-folder-open" aria-hidden="true"></i> @ucfirst(__('app.editCat'))
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
        <form action="{{ route('category.update') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="user_uuid" value="{{ $currentUser->uuid }}" />
            <input type="hidden" name="cat_uuid" value="{{ $category->uuid }}" />
            <div class="">
                <p class="text-justify">
                    @ucfirst(__('app.updCatInstruction'))
                </p>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-category"><i class="fas fa-folder-open" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="name" class="form-control border-secondary" placeholder="@ucfirst(__('app.formCategory'))" value="{{ $category->name }}" aria-label="@ucfirst(__('app.category'))" aria-describedby="input-category"@empty($category->user_uuid) {{ 'readonly' }} @endempty />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-icon"><i class="fas fa-image" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="icon" class="form-control border-secondary" placeholder="@ucfirst(__('app.formIcon'))" value="{{ $category->icon }}" aria-label="@ucfirst(__('app.formIcon'))" aria-describedby="input-icon"@empty($category->user_uuid) {{ 'readonly' }} @endempty />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-color"><i class="fas fa-palette" aria-hidden="true"></i></span>
                </div>
                <input type="text" name="color" class="form-control border-secondary" autocomplete="off" value="{{ $category->icon }}" placeholder="@ucfirst(__('app.formColor'))" aria-label="@ucfirst(__('app.formColor'))" aria-describedby="input-color" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="input-description"><i class="fas fa-comment-alt" aria-hidden="true"></i></span>
                </div>
                <textarea id="descForm" name="description" class="form-control border-secondary" placeholder="@ucfirst(__('app.formDescription'))" rows="5" aria-label="@ucfirst(__('app.formDescription'))" aria-describedby="input-description"@empty($category->user_uuid) {{ 'readonly' }} @endempty />{{ $category->description }}</textarea>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-folder-plus" aria-hidden="true"></i> @ucfirst(__('app.save'))</button>
            </div>
        </form>
    </div>
</div>
@endsection