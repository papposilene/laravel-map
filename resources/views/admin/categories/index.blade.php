@extends('layouts.admin')
@section('title', @ucfirst(__('app.categoriesList')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3 px-5">
        <i class="fas fa-folder" aria-hidden="true"></i> @ucfirst(trans_choice('app.categories', 2))
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
@if('status' === 'addOk')
<div class="col-6 alert alert-success" role="alert">
    @ucfirst(__('app.addSuccess'))
</div>
@endif
@if('status' === 'resOk')
<div class="col-6 alert alert-success" role="alert">
    @ucfirst(__('app.resSuccess'))
</div>
@endif
@if('status' === 'delOk')
<div class="col-6 alert alert-success" role="alert">
    @ucfirst(__('app.delSuccess'))
</div>
@endif
<div class="row d-flex justify-content-center" id="categories-list">
    <div class="col-6 mb-3">
        <div class="row">
            <div class="col-8">
                <input type="text" class="form-control form-control-sm search border-secondary w-100" autocomplete="off" placeholder="@ucfirst(__('app.search'))" />
            </div>
            <div class="col-4 text-right">
                <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">@ucfirst(__('app.newCat'))</a>
                @isset($query)
                <a href="{{ route('category.admin') }}" class="btn btn-sm btn-outline-success"><i class="fas fa-history" aria-hidden="true"></i></a>
                @else
                <a href="{{ route('category.admin', ['deleted' => 1]) }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash" aria-hidden="true"></i></a>
                @endisset
            </div>
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-6">
        <ul class="list-group list list-group-flush">
            @foreach($categories as $category)
            @php
            $deleted = (isset($category->deleted_at) ? ' border-danger' : '');
            @endphp
            <li class="list-group-item{{ $deleted }}">
                <span class="badge badge-light badge-pill float-right">
                    <a href="{{ route('category.index', ['slug' => $category->slug]) }}" class="text-primary"><i class="fas fa-list-ul" aria-hidden="true"></i></a> |
                    <a href="{{ route('category.edit', ['uuid' => $category->uuid]) }}" class="text-info"><i class="fas fa-edit" aria-hidden="true"></i></a>
                    @isset($category->user_uuid)
                    @isset($category->deleted_at)
                    | <a href="{{ route('category.restore', ['uuid' => $category->uuid]) }}" class="text-success"><i class="fas fa-trash-restore" aria-hidden="true"></i></a>
                    @else
                    | <a href="{{ route('category.delete', ['uuid' => $category->uuid]) }}" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i></a>
                    @endisset
                    @endisset
                </span>
                <h2 class="h4 category-name"><i class="fas fa-{{ $category->icon }}" aria-hidden="true"></i> {{ $category->name }}</h2>
                <p class="category-desc mb-1">{{ $category->description }}</p>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/list.min.js') }}"></script>
<script type="text/javascript">
var countriesList = new List('categories-list', {
    valueNames: ['category-name', 'category-desc']
});
</script>
@endsection