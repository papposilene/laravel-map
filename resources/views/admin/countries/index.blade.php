@extends('layouts.admin')
@section('title', @ucfirst(__('app.countriesList')))
@section('css-file')
<link rel="stylesheet" href="{{ asset('/css/leaflet.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.awesome-markers.min.css') }}" />
@endsection
@section('css-style')
<style>
#map-countries {
    height: 370px;
    width: 100%;
}
.faMarker{font-family: FontAwesome; margin-top: 8px;}
</style>
@endsection

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3">
        <i class="fas fa-atlas" aria-hidden="true"></i> @ucfirst(__('app.countriesList'))
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
<div class="row d-flex justify-content-center">
    <div class="col-6 mb-3">
        <div id="map-countries"></div>
    </div>
</div>
<div class="row d-flex justify-content-center" id="countries-list">
    <div class="col-6 mb-3">
        <div class="row">
            <div class="col-8">
                <input type="text" class="form-control form-control-sm search border-secondary w-100" autocomplete="off" placeholder="@ucfirst(__('app.search'))" />
            </div>
            <div class="col-4 text-right">
                <a href="{{ route('country.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-map-pin" aria-hidden="true"></i> @ucfirst(__('app.newCou'))
                </a>
            </div>
        </div>
    </div>
    <div class="w-100"></div>
    <ul class="col-6 list list-group list-group-flush">
        @foreach($countries as $country)
        @php
        $ctrFiltering = $visited->where('country_uuid', $country->uuid);
        $ctrFiltered = $ctrFiltering->pluck('uuid')->toArray();
        $l18nCountry = json_decode($country->name_translations, true);
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
        $addFiltering = $addresses->where('country_uuid', $country->uuid);
        $addFiltered = $addFiltering->pluck('uuid')->toArray();
        $addCount = count($addFiltered);
        @endphp
        <li class="list-group-item">
            <form action="{{ route('country.update') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="uuid" value="{{ $ctrFiltered[0] }}" />
                <input type="hidden" name="country_uuid" value="{{ $country->uuid }}" />
                <input type="hidden" name="user_uuid" value="{{ $currentUser->uuid }}" />
                <span class="badge badge-light badge-pill float-right">
                    <a href="{{ route('map', ['country' => $country->cca3]) }}" class="btn btn-sm text-primary" target="_blank" rel="noopener"><i class="fas fa-map-marked-alt" aria-hidden="true"></i></a>
                    <a href="{{ route('address.admin', ['country' => $country->uuid]) }}" class="btn btn-sm text-info" target="_blank" rel="noopener"><i class="fas fa-database" aria-hidden="true"></i></a>
                    <a href="{{ route('address.create', ['country' => $country->uuid]) }}" class="btn btn-sm"><i class="fas fa-plus text-info" aria-hidden="true"></i></a>
                    <button type="submit" class="btn btn-sm"><i class="fas fa-trash text-danger" aria-hidden="true"></i></button>
                </span>
                <h2 class="h4 country-name">{{ $country->flag }} {{ $l10nCommon }}</h2>
                <p class="text-left">
                    @ucfirst(__('app.officially')), {{ $l10nOfficial }} ({{ $country->cca3 }}).<br />
                    @ucfirst(__('app.localized')) {{ $country->region }} / {{ $country->subregion }}.<br />
                    @if($addCount > 0)
                    @ucfirst(trans_choice('app.addresses', $addCount)) : {{ $addCount }}.
                    @else
                    <a href="{{ route('address.create', ['country' => $country->uuid]) }}">@ucfirst(__('app.newAdd')).</a>
                    @endisset
                </p>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/leaflet.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/leaflet.awesome-markers.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/list.min.js') }}"></script>
<script type="text/javascript">
var greenMarker = L.AwesomeMarkers.icon({
	icon: 'map-marker-alt',
	prefix: 'fa',
	markerColor:'green'
});
var mapTiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});
$.getJSON("{{ route('api.countries.point', ['user' => $currentUser->uuid]) }}",function(data){
    var map = L.map('map-countries').setView([20, 0], 1);
    var geojson = L.geoJson(data, {
            pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {icon:greenMarker});
                }
        });
    mapTiles.addTo(map);
    geojson.addTo(map);
});
var countriesList = new List('countries-list', {
    valueNames: ['country-name']
});
</script>
@endsection