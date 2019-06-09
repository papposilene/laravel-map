@extends('layouts.admin')
@section('title', @ucfirst(__('app.userMgmt')))

@section('main')
<main role="main" id="main" class="container-fluid">
    <div class="row d-flex justify-content-center">
        <h1 class="col-12 mb-3 font-weight-normal">
            <i class="fas fa-atlas" aria-hidden="true"></i> @ucfirst(__('app.userMgmt'))
        </h1>
        <div class="col-6">
            <ul class="list-group list-group-flush">
                @foreach($categories as $category)
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h2 id="catName" class="h5 mb-1"><i class="fas fa-{{ $category->icon }}" aria-hidden="true"></i> {{ $category->name }}</h2>
                    </div>
                    <p class="mb-1">{{ $category->description }}</p>
                    <p class="mb-1 text-right">
                        <small>
                            <a href="{{ route('category.index', ['slug' => $category->slug]) }}" class="text-primary"><i class="fas fa-list-ul" aria-hidden="true"></i></a> |
                            <a href="{{ route('category.admin', ['uuid' => $category->uuid]) }}" class="text-info" type="submit" role="button"><i class="fas fa-edit" aria-hidden="true"></i></a> |
                            <a href="{{ route('category.delete', ['uuid' => $category->uuid]) }}" class="text-danger" type="submit" role="button"><i class="fas fa-trash" aria-hidden="true"></i></a>
                        </small>
                    </p>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-6">
            <form action="{{ route('user.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input-uuid"><i class="fas fa-fingerprint" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="uuid" class="form-control" placeholder="@ucfirst(__('app.formUuid'))" value="@if($editingcat) {{ $editingcat->uuid }} @endif" aria-label="@ucfirst(__('app.formUuid'))" aria-describedby="input-uuid" readonly />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input-category"><i class="fas fa-folder-open" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="category" class="form-control" placeholder="@ucfirst(__('app.formCategory'))" value="@if($editingcat) {{ $editingcat->name }} @endif" aria-label="@ucfirst(__('app.category'))" aria-describedby="input-category" />
                </div>
                <div class="form-row">
                    <div class="col input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="input-slug"><i class="fas fa-folder" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="slug" class="form-control" placeholder="@ucfirst(__('app.formSlug'))" value="@if($editingcat) {{ $editingcat->slug }} @endif" aria-label="@ucfirst(__('app.formSlug'))" aria-describedby="input-slug" />
                    </div>
                    <div class="col input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="input-icon"><i class="fas fa-map-pin" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="icon" class="form-control" placeholder="@ucfirst(__('app.formIcon'))" value="@if($editingcat) {{ $editingcat->icon }} @endif" aria-label="@ucfirst(__('app.formIcon'))" aria-describedby="input-icon" />
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input-description"><i class="fas fa-folder-open" aria-hidden="true"></i></span>
                    </div>
                    <textarea id="descForm" name="description" class="form-control" placeholder="@ucfirst(__('app.formDescription'))" rows="5" aria-label="@ucfirst(__('app.formDescription'))" aria-describedby="input-description" />@if($editingcat) {{ $editingcat->description }} @endif</textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">@ucfirst(__('app.save'))</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection