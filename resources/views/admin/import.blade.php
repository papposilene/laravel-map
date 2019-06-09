@extends('layouts.admin')
@section('title', @ucfirst(__('app.impData')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3 px-5"><i class="fas fa-file-upload" aria-hidden="true"></i> @ucfirst(__('app.impData'))</h1>
</div>
@if (session('notification') === 'impOk')
<div class="row d-flex justify-content-center">
    <div class="col-6 alert alert-success">
        @ucfirst(__('app.impSuccess'))
    </div>
</div>
@endif
@if (session('notification') === 'impFail')
<div class="row d-flex justify-content-center">
    <div class="col-6 alert alert-danger">
        @ucfirst(__('app.impFail'))
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
<div class="row mt-3 d-flex justify-content-center">
    <div class="col-6">
        <div class="row">
            <div class="col-12">
                <h3><i class="fas fa-globe" aria-hidden="true" /></i> @ucfirst(__('app.countriesList'))</h3>
                <small>
                    @ucfirst(__('app.supportedColumns')) : @ucfirst(__('app.formCca2')), @ucfirst(__('app.formCca3')).
                </small>
            </div>
        </div>
        <div class="row pt-3 mb-5">
            <form class="col-12" action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="user_countries" />
                <div class="row">
                    <div class="col-9">
                        <div class="custom-file">
                            <input class="custom-file-input" id="customFile" name="importedfile" type="file">
                            <label class="custom-file-label" for="customFile">@ucfirst(__('app.formImportFile'))</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-file-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <h3><i class="fas fa-folder" aria-hidden="true" /></i> @ucfirst(__('app.categoriesList'))</h3>
                <small>
                    @ucfirst(__('app.supportedColumns')) : @ucfirst(__('app.formCca2')), @ucfirst(__('app.formCca3')).
                </small>
            </div>
        </div>
        <div class="row pt-3 mb-5">
            <form class="col-12" action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="user_categories" />
                <div class="row">
                    <div class="col-9">
                        <div class="custom-file">
                            <input class="custom-file-input" id="customFile" name="importedfile" type="file">
                            <label class="custom-file-label" for="customFile">@ucfirst(__('app.formImportFile'))</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-file-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <h3><i class="fas fa-map-pin" aria-hidden="true" /></i> @ucfirst(__('app.addressesList'))</h3>
                <small>
                    @ucfirst(__('app.supportedColumns')) : @ucfirst(__('app.formName')), @ucfirst(__('app.formAddress')),
                    @ucfirst(__('app.formCategory')), @ucfirst(__('app.formCca3')), @ucfirst(__('app.formDescription')).
                </small>
            </div>
        </div>
        <div class="row pt-3 mb-5">
            <form class="col-12" action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="user_addresses" />
                <div class="row">
                    <div class="col-9">
                        <div class="custom-file">
                            <input class="custom-file-input" id="customFile" name="importedfile" type="file">
                            <label class="custom-file-label" for="customFile">@ucfirst(__('app.formImportFile'))</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-file-upload" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection