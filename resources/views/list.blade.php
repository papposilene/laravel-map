@extends('layouts.app')
@section('title', @ucfirst(__('app.countriesList')))

@section('navbar')
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
    <a class="navbar-brand" href="{{ route('home', ['user' => $usrInfo->uuid]) }}">{{ $appName }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
        </ul>
        @auth
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-database"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
        @else
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i></a>
            </li>
        </ul>
        @endauth
    </div>
</nav>
@endsection

@section('main')
<div class="row px-4 d-flex justify-content-center">
    <div class="col-9 mb-3 table-responsive">
        <a href="{{ route('map') }}" class="btn btn-lg btn-primary btn-block">
            @ucfirst(__('app.allMap'))
        </a>
    </div>
    <div class="w-100"></div>
    <div class="col-6 mb-3 table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <th colspan="2" scope="col">
                    <button class="btn btn-secondary btn-block" disabled>@ucfirst(__('app.countriesList'))</button>
                </th>
            </tr>
            @foreach($visited->chunk(2) as $chunked)
            <tr>
                @foreach($chunked as $country)
                @php
                $ctrFiltering = $countries->where('uuid', $country->country_uuid);
                $ctrFiltered = $ctrFiltering->first();
                $l18nCountry = json_decode($ctrFiltered['name_translations'], true);
                if(array_key_exists($currentLocale, $l18nCountry))
                {
                    $l10nCommon = $l18nCountry[$currentLocale]['common'];
                    $l10nOfficial = $l18nCountry[$currentLocale]['official'];
                }
                else
                {
                    $l10nCommon = $country->name_eng_common;
                    $l10nOfficial = $country->name_eng_official;
                }
                $ctrCountFiltering = $addresses->where('country_uuid', $country->country_uuid);
                $ctrCountFiltered = $ctrCountFiltering->pluck('uuid')->toArray();
                $ctrCount = count($ctrCountFiltered);
                @endphp
                <td class="w-50">
                    <a href="{{ route('map', ['country' => $ctrFiltered->cca3, 'user' => $usrInfo->uuid]) }}" class="btn btn-light btn-block text-left">
                        <span class="text-primary float-right">
                            {{ $ctrCount }}
                        </span>
                        {{ $ctrFiltered->flag }} {{ $l10nCommon }}
                    </a>
                </td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-3 mb-3 table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <th scope="col">
                    <button class="btn btn-secondary btn-block" disabled>@ucfirst(__('app.categoriesList'))</button>
                </th>
            </tr>
            @foreach($categories as $category)
            @php
            $catCountFiltering = $addresses->where('category_uuid', $category->uuid);
            $catCountFiltered = $catCountFiltering->pluck('uuid')->toArray();
            $catCount = count($catCountFiltered);
            @endphp
            <tr>
                <td>
                    <a href="{{ route('map', ['category' => $category->uuid, 'user' => $usrInfo->uuid]) }}" class="btn btn-light btn-block text-left{{ (($catCount != 0) ? '' : ' disabled') }}">
                        <span class="text-primary float-right">
                            {{ $catCount }}
                        </span>
                        <i class="fas fa-{{ $category->icon }}"></i> {{ $category->name }}
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection