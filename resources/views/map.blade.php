@extends('layouts.app')
@section('title', __('app.appname'))
@section('css-file')
<link rel="stylesheet" href="{{ asset('/css/leaflet.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.awesome-markers.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.control-sidebar.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.control-locate.min.css') }}" />
@endsection
@section('css-style')
<style>
#map-container {
    height: 100%;
    width: 100%;
    position: fixed;
    margin: 0;
    padding: 0;
    top: 4.5em;
    left: 0;
}
.leaflet-sidebar .close {
    color: #000 !important;
    z-index: 1000 !important;
}
</style>
@endsection

@section('navbar')
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">{{ $appName }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownAfrica" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-africa" aria-hidden="true"></i> {{ __('app.africa') }}</a>
                @if(count($afCountries) > 0)
                <div class="dropdown-menu" aria-labelledby="dropdownAfrica">
                    @foreach ($afCountries as $afCountry)
                    @php
                    $afNCountry = json_decode($afCountry['name_translations'], true);
                    if(array_key_exists($currentLocale, $afNCountry))
                    {
                        $afrCountry = $afNCountry[$currentLocale]['common'];
                    }
                    else
                    {
                        $afrCountry = $afNCountry['name_eng_common'];
                    }
                    @endphp
                    <a class="dropdown-item" href="{{ route('map', ['user' => $usrInfo->uuid, 'country' => $afCountry->cca3, 'category' => $catInfo->uuid]) }}">{{ $afCountry->flag }} {{ $afrCountry }}</a>
                    @endforeach
                </div>
                @endif
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownAmericas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-americas" aria-hidden="true"></i> {{ __('app.americas') }}</a>
                @if(count($amCountries) > 0)
                <div class="dropdown-menu" aria-labelledby="dropdownAmericas">
                    @foreach ($amCountries as $amCountry)
                    @php
                    $amNCountry = json_decode($amCountry['name_translations'], true);
                    if(array_key_exists($currentLocale, $amNCountry))
                    {
                        $ameCountry = $amNCountry[$currentLocale]['common'];
                    }
                    else
                    {
                        $ameCountry = $amNCountry['name_eng_common'];
                    }
                    @endphp
                    <a class="dropdown-item" href="{{ route('map', ['user' => $usrInfo->uuid, 'country' => $amCountry->cca3, 'category' => $catInfo->uuid]) }}">{{ $amCountry->flag }} {{ $ameCountry }}</a>
                    @endforeach
                </div>
                @endif
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownAsia" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-asia" aria-hidden="true"></i> {{ __('app.asia') }}</a>
                @if(count($asCountries) > 0)
                <div class="dropdown-menu" aria-labelledby="dropdownAsia">
                    @foreach ($asCountries as $asCountry)
                    @php
                    $asNCountry = json_decode($asCountry['name_translations'], true);
                    if(array_key_exists($currentLocale, $asNCountry))
                    {
                        $asiCountry = $asNCountry[$currentLocale]['common'];
                    }
                    else
                    {
                        $asiCountry = $asNCountry['name_eng_common'];
                    }
                    @endphp
                    <a class="dropdown-item" href="{{ route('map', ['user' => $usrInfo->uuid, 'country' => $asCountry->cca3, 'category' => $catInfo->uuid]) }}">{{ $asCountry->flag }} {{ $asiCountry }}</a>
                    @endforeach
                </div>
                @endif
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="country" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-europe" aria-hidden="true"></i> {{ __('app.europa') }}</a>
                @if(count($euCountries) > 0)
                <div class="dropdown-menu" aria-labelledby="dropdownEuropa">
                    @foreach ($euCountries as $euCountry)
                    @php
                    $euNCountry = json_decode($euCountry['name_translations'], true);
                    if(array_key_exists($currentLocale, $euNCountry))
                    {
                        $eurCountry = $euNCountry[$currentLocale]['common'];
                    }
                    else
                    {
                        $eurCountry = $euNCountry['name_eng_common'];
                    }
                    @endphp
                    <a class="dropdown-item" href="{{ route('map', ['user' => $usrInfo->uuid, 'country' => $euCountry->cca3, 'category' => $catInfo->uuid]) }}">{{ $euCountry->flag }} {{ $eurCountry }}</a>
                @endforeach
                </div>
                @endif
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownOceania" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-asia" aria-hidden="true"></i> {{ __('app.oceania') }}</a>
                @if(count($ocCountries) > 0)
                <div class="dropdown-menu" aria-labelledby="dropdownOceania">
                    @foreach ($ocCountries as $ocCountry)
                    @php
                    $ocNCountry = json_decode($ocCountry['name_translations'], true);
                    if(array_key_exists($currentLocale, $ocNCountry))
                    {
                        $oceCountry = $ocNCountry[$currentLocale]['common'];
                    }
                    else
                    {
                        $oceCountry = $ocNCountry['name_eng_common'];
                    }
                    @endphp
                    <a class="dropdown-item" href="{{ route('map', ['user' => $usrInfo->uuid, 'country' => $ocCountry->cca3, 'category' => $catInfo->uuid]) }}">{{ $ocCountry->flag }} {{ $oceCountry }}</a>
                @endforeach
                </div>
                @endif
            </li>
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
<main role="main" class="container">
    <div id="map-container"></div>
    <div id="map-sidebar"></div>
</main>
@endsection

@section('footer')
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/leaflet.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/leaflet.awesome-markers.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/leaflet.control-sidebar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/leaflet.control-locate.min.js') }}"></script>
<script type="text/javascript">
@php
$geoloc = json_decode($ctrInfo->latlng, true);
$lat = (float) $geoloc['lng'];
$lng = (float) $geoloc['lat'];
$zoom = (isset($ctrInfo->cca3) ? '6' : '2');
@endphp
var usrMap = L.map('map-container').setView([{{ $lat }}, {{ $lng }}], {{ $zoom }});
var sidebar = L.control.sidebar('map-sidebar', {
    position: 'left',
    closeButton: true,
    autoPan: true
});
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    subdomains: 'abc',
    minZoom: 0,
    maxZoom: 19,
    crossOrigin: true
}).addTo(usrMap);
L.control.locate({
    flyTo:true,
    icon: 'fas fa-map-marker',
    iconLoading: 'fas fa-spinner fa-spin',
    strings: {
        title: "Show me where I am, yo!"
    }
}).addTo(usrMap);
$.getJSON("{!! route('api.addresses.point', ['user' => $usrInfo->uuid, 'country' => $ctrInfo->cca3, 'category' => $catInfo->uuid]) !!}", function(data){
    L.geoJson(data, {
        onEachFeature: function(feature, layer) {
            layer.on('click',function(){
                sidebar.show(),
                sidebar.setContent(
                        '<h2 class="h3 mt-3"><i class="fas fa-' + feature.properties.category_icon + '"></i> ' + feature.properties.name + '</h2>' +
                        '<p class="my-3 text-right">' + feature.properties.country_flag + ' ' + feature.properties.country_common + '<br />' +
                        '<i class="fas fa-' + feature.properties.category_icon + '"></i> ' + feature.properties.category_name + '</p>' + 
                        '<p class="text-justify">' + feature.properties.address + '.</p>' +
                        '<p class="text-justify">' + feature.properties.description + '</p>' +
                        '<p class="text-justify"><a href="' + feature.properties.url + '" target="_blank" rel="noopener"><i class="fas fa-link"></i> @ucfirst(__('app.website'))</a><br />' +
                        '<a href="tel: ' + feature.properties.phone + '"><i class="fas fa-phone"></i> ' + feature.properties.phone + '</a><br />' +
                        '<a href="https://www.google.com/maps/search/?api=1&query=' + feature.properties.latlng + '" target="_blank" rel="noopener"><i class="fas fa-globe"></i> ' + feature.properties.latlng + '</a></p>'
                )
            })
        },
        pointToLayer: function(feature, latlng) {
            return marker = L.marker(latlng, {icon: L.AwesomeMarkers.icon({markerColor: feature.properties.color, prefix: 'fa', extraClasses: 'fas', icon: feature.properties.category_icon}) });
        }
    }).addTo(usrMap);
});
usrMap.addControl(sidebar);
</script>
@endsection