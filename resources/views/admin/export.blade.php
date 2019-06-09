@extends('layouts.admin')
@section('title', @ucfirst(__('app.expData')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3"><i class="fas fa-file-upload" aria-hidden="true"></i> @ucfirst(__('app.expData'))</h1>
</div>
@if (session('status') === 'expOk')
<div class="row d-flex justify-content-center">
    <div class="col-6 alert alert-success">
        @ucfirst(__('app.expSuccess'))
    </div>
</div>
@endif
@if (session('status') === 'expFail')
<div class="row d-flex justify-content-center">
    <div class="col-6 alert alert-danger">
        @ucfirst(__('app.expFail'))
    </div>
</div>
@endif
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
        <div class="">
            <p class="text-justify">
                @ucfirst(__('app.expInstruction'))
            </p>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="h4"><i class="fas fa-globe" aria-hidden="true"></i> @ucfirst(__('app.countriesList'))</h3>
                @ucfirst(__('app.exportedColumns')) : @ucfirst(__('app.formCca3')).
            </div>
        </div>
        <div class="row pt-3 mb-5">
            <div class="col-3 text-center">
                <a href="{{ route('export.countries', ['type' => 'xlsx']) }}" class="text-primary"><i class="fas fa-file-excel" aria-hidden="true"></i> Excel</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.countries', ['type' => 'csv']) }}" class="text-primary"><i class="fas fa-file-csv" aria-hidden="true"></i> CSV</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.countries', ['type' => 'ods']) }}" class="text-primary"><i class="fas fa-file-alt" aria-hidden="true"></i> ODS</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.countries', ['type' => 'html']) }}" class="text-primary"><i class="fas fa-file-code" aria-hidden="true"></i> HTML</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="h4"><i class="fas fa-folder" aria-hidden="true" /></i> @ucfirst(__('app.categoriesList'))</h3>
                @ucfirst(__('app.exportedColumns')) : @ucfirst(__('app.formName')), @ucfirst(__('app.formIcon')), @ucfirst(__('app.formDescription')).
            </div>
        </div>
        <div class="row pt-3 mb-5">
            <div class="col-3 text-center">
                <a href="{{ route('export.categories', ['type' => 'xlsx']) }}" class="text-primary"><i class="fas fa-file-excel" aria-hidden="true"></i> Excel</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.categories', ['type' => 'csv']) }}" class="text-primary"><i class="fas fa-file-csv" aria-hidden="true"></i> CSV</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.categories', ['type' => 'ods']) }}" class="text-primary"><i class="fas fa-file-alt" aria-hidden="true"></i> ODS</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.categories', ['type' => 'html']) }}" class="text-primary"><i class="fas fa-file-code" aria-hidden="true"></i> HTML</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="h4"><i class="fas fa-map-pin" aria-hidden="true" /></i> @ucfirst(__('app.addressesList'))</h3>
                @ucfirst(__('app.exportedColumns')) : @ucfirst(__('app.formName')), @ucfirst(__('app.formAddress')), @ucfirst(__('app.formGeoloc')),
                @ucfirst(__('app.formCountry')), @ucfirst(__('app.formCategory')), 
                @ucfirst(__('app.formPhone')), @ucfirst(__('app.formUrl')), @ucfirst(__('app.formDescription')).
            </div>
        </div>
        <div class="row pt-3 mb-5">
            <div class="col-3 text-center">
                <a href="{{ route('export.addresses', ['type' => 'xlsx']) }}" class="text-primary"><i class="fas fa-file-excel" aria-hidden="true"></i> Excel</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.addresses', ['type' => 'csv']) }}" class="text-primary"><i class="fas fa-file-csv" aria-hidden="true"></i> CSV</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.addresses', ['type' => 'ods']) }}" class="text-primary"><i class="fas fa-file-alt" aria-hidden="true"></i> ODS</a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('export.addresses', ['type' => 'html']) }}" class="text-primary"><i class="fas fa-file-code" aria-hidden="true"></i> HTML</a>
            </div>
        </div>
    </div>
</div>
@endsection