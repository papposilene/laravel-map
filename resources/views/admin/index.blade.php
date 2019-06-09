@extends('layouts.admin')
@section('title', @ucfirst(__('app.admin')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3 px-5">
        <i class="fas fa-user-cog" aria-hidden="true"></i> @ucfirst(__('app.admin'))
    </h1>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-6">
        <div class="row">
            <div class="card-deck col-12">
                <div class="card mb-4">
                    <h5 class="card-header">@ucfirst(trans_choice('app.user', 1))</h5>
                    <div class="card-body">
                        <p class="card-text">
                            <i class="fas fa-user" aria-hidden="true"></i> {{ $userData->username }}<br />
                            @isset($userData->lname)
                            <i class="fas fa-id-card" aria-hidden="true"></i> {{ $userData->title }} {{ $userData->fname }} {{ $userData->lname }}<br />
                            @endisset
                            <span class="@isset($userData->email_verified_at) {{ 'text-success' }} @endisset">
                                <i class="fas fa-at" aria-hidden="true"></i> {{ $userData->email }}
                            </span>
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted">
                            {{ __('app.updatedat', ['date' => $userData->updated_at->format('d/m/Y, H:i')]) }}.
                        </small>
                    </div>
                </div>
                <div class="card mb-4">
                    <h5 class="card-header">@ucfirst(__('app.admin'))</h5>
                    <div class="card-body">
                        <p class="card-text">
                            <a href="{{ route('address.create') }}" class="text-dark"><i class="fas fa-map-pin" aria-hidden="true"></i> @ucfirst(__('app.newAdd'))</a><br />
                            <a href="{{ route('category.create') }}" class="text-dark"><i class="fas fa-folder" aria-hidden="true"></i> @ucfirst(__('app.newCat'))</a><br />
                            <a href="{{ route('country.create') }}" class="text-dark" class="text-dark"><i class="fas fa-atlas" aria-hidden="true"></i> @ucfirst(__('app.newCou'))</a><br />
                            <a href="{{ route('import.index') }}" class="text-dark"><i class="fas fa-file-upload" aria-hidden="true"></i> @ucfirst(__('app.formImportFile'))</a><br />
                            <a href="{{ route('export.index') }}" class="text-dark"><i class="fas fa-file-download" aria-hidden="true"></i> @ucfirst(__('app.formExportFile'))</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-deck col-12">
                <div class="card mb-4">
                    <h5 class="card-header">
                        <span class="badge badge-pill float-right">
                            <a href="{{ route('address.create') }}" class="text-info"><i class="fas fa-plus" aria-hidden="true"></i></a>
                        </span>
                        @ucfirst(trans_choice('app.addresses', 2))
                    </h5>
                    <div class="card-body">
                        <p class="card-text text-justify">
                            @ucfirst(__('app.appTotalData', ['data' => trans_choice('app.addresses', $totalAddresses), 'count' => $totalAddresses]))
                            @if($totalUserAddresses > 0)
                                @ucfirst(__('app.userTotalData', ['data' => trans_choice('app.addresses', $totalUserAddresses), 'count' => $totalUserAddresses]))
                            @else
                                @ucfirst(__('app.userNoData', ['data' => trans_choice('app.addresses', $totalUserAddresses)]))
                            @endif
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted">
                            {{ __('app.updatedat', ['date' => $lastAddress->updated_at->format('d/m/Y, H:i')]) }}.
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-deck col-12">
                <div class="card mb-4">
                    <h5 class="card-header">
                        <span class="badge badge-pill float-right">
                            <a href="{{ route('category.create') }}" class="text-info"><i class="fas fa-plus" aria-hidden="true"></i></a>
                        </span>
                        @ucfirst(trans_choice('app.categories', 2))
                    </h5>
                    <div class="card-body">
                        <p class="card-text text-justify">
                            @ucfirst(__('app.appTotalData', ['data' => trans_choice('app.categories', $totalCategories), 'count' => $totalCategories]))
                            @if($totalUserCategories > 0)
                                @ucfirst(__('app.userTotalData', ['data' => trans_choice('app.categories', $totalUserCategories), 'count' => $totalUserCategories]))
                            @else
                                @ucfirst(__('app.userNoData', ['data' => trans_choice('app.categories', $totalUserCategories)]))
                            @endif
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted">
                            {{ __('app.updatedat', ['date' => $lastCategory->updated_at->format('d/m/Y, H:i')]) }}.
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-deck col-12">
                <div class="card mb-4">
                    <h5 class="card-header">
                        <span class="badge badge-pill float-right">
                            <a href="{{ route('country.create') }}" class="text-info"><i class="fas fa-plus" aria-hidden="true"></i></a>
                        </span>
                        @ucfirst(trans_choice('app.countries', 2))
                    </h5>
                    <div class="card-body">
                        <p class="card-text text-justify">
                            @ucfirst(__('app.appTotalData', ['data' => trans_choice('app.countries', $totalCountries), 'count' => $totalCountries]))
                            @if($totalUserCountries > 0)
                                @ucfirst(__('app.userTotalData', ['data' => trans_choice('app.countries', $totalUserCountries), 'count' => $totalUserCountries]))
                            @endif
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <small class="text-muted">
                            {{ __('app.updatedat', ['date' => $lastCountry->updated_at->format('d/m/Y, H:i')]) }}.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
