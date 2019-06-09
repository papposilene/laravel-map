@extends('layouts.admin')
@section('title', @ucfirst(__('app.editAdd')))
@section('css-file')
<link rel="stylesheet" href="{{ asset('/css/jquery-ui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.control-geocoder.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.awesome-markers.min.css') }}" />
@endsection
@section('css-style')
<style>
#map-new {
    height: 300px;
    width: 100%;
}
.faMarker{font-family: FontAwesome; margin-top: 8px;}
</style>
@endsection

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-6 h2 mb-3">
        <i class="far fa-address-book" aria-hidden="true"></i> @ucfirst(__('app.editAdd'))
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
        <form action="{{ route('address.update') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="user_uuid" value="{{ $address->user_uuid }}" />
            <input type="hidden" name="addr_uuid" value="{{ $address->uuid }}" />
            <input type="hidden" name="place_id" id="place_id" value="{{ $address->place_id }}" />
            <div class="">
                <p class="text-justify">
                    @ucfirst(__('app.updAddInstruction'))
                </p>
            </div>
            <div class="input-group border-secondary mb-3">    
                <div id="map-new" class="rounded"></div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="formName"><i class="fas fa-address-card" aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control border-secondary" name="name" id="name" autocomplete="off" value="{{ $address->name }}" placeholder="@ucfirst(__('app.formName'))" aria-label="@ucfirst(__('app.formName'))" aria-describedby="formName" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary"><i class="fas fa-map-marked-alt" aria-hidden="true"></i></span>
                </div>
                <textarea class="form-control border-secondary" name="address" id="address" autocomplete="off" rows="3" placeholder="@ucfirst(__('app.formAddress'))" aria-label="@ucfirst(__('app.formAddress'))">{{ $address->address }}</textarea>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text border-secondary" for="formGeoloc"><i class="fas fa-globe" aria-hidden="true"></i></label>
                </div>
                <input type="text" class="form-control border-secondary" name="latlng" id="geoloc" autocomplete="off" value="{{ $address->latlng }}" placeholder="@ucfirst(__('app.formGeoloc'))" aria-label="@ucfirst(__('app.formGeoloc'))" aria-describedby="formGeoloc" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text border-secondary" for="formCountry"><i class="fas fa-map" aria-hidden="true"></i></label>
                </div>
                @php
                $filterngCtr = $countries->whereStrict('uuid', $address->country_uuid);
                $filteredCtr = $filterngCtr->first();
                @endphp
                <input type="text" class="form-control border-secondary" id="countries" autocomplete="off" value="{{ $filteredCtr->name_eng_common }}" readonly placeholder="@ucfirst(__('app.formCountry'))" aria-label="@ucfirst(__('app.formCountry'))" aria-describedby="formCountry" />
                <input type="hidden" name="country_uuid" id="country_uuid" value="{{ $filteredCtr->uuid }}" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text border-secondary" for="formCategory"><i class="fas fa-folder-open" aria-hidden="true"></i></label>
                </div>
                @php
                $filterngCat = $categories->whereStrict('uuid', $address->category_uuid);
                $filteredCat = $filterngCat->first();
                @endphp
                <input type="text" class="form-control border-secondary" id="categories" autocomplete="off" value="{{ $filteredCat->name }}" placeholder="@ucfirst(__('app.formCategory'))" aria-label="@ucfirst(__('app.formCategory'))" aria-describedby="formCategory" />
                <input type="hidden" name="category_uuid" id="category_uuid" value="{{ $filteredCat->uuid }}" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="formPhone"><i class="fas fa-phone" aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control border-secondary" name="phone" autocomplete="off" value="{{ $address->phone }}" placeholder="@ucfirst(__('app.formPhone'))" aria-label="@ucfirst(__('app.formPhone'))" aria-describedby="formPhone">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary" id="formUrl"><i class="fas fa-link" aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control border-secondary" name="url" autocomplete="off" value="{{ $address->url }}" placeholder="@ucfirst(__('app.formUrl'))" aria-label="@ucfirst(__('app.formUrl'))" aria-describedby="formUrl">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text border-secondary"><i class="fas fa-comment-alt" aria-hidden="true"></i></span>
                </div>
                <textarea class="form-control border-secondary" name="description" autocomplete="off" rows="5" placeholder="@ucfirst(__('app.formDescription'))" aria-label="@ucfirst(__('app.formDescription'))">{{ $address->description }}</textarea>
            </div>
            <div class="mb-3 text-right">
                <small class="text-muted float-left"><em>
                    {{ __('app.createdat', ['date' => $address->created_at->format('d/m/Y, H:i:s')]) }}.
                    {{ __('app.updatedat', ['date' => $address->updated_at->format('d/m/Y, H:i:s')]) }}.
                </em></small>
                <button type="submit" class="btn btn-primary">@ucfirst(__('app.save'))</button>
            </div>
		</form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/leaflet.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/leaflet.awesome-markers.min.js') }}"></script>
<script type="text/javascript">
$( function() {
    $("#categories").autocomplete({
        source: function (request, response) {
            $.getJSON("{{ route('api.categories.listing', ['user' => $currentUser->uuid, 'query']) }}=" + request.term, function (data) {
                response($.map(data.categories, function (value, key) {
                    return {
                        label: value.name,
                        value: value.name,
                        uuid: value.uuid
                    };
                }));
            });
        },
		minLength: 3,
		select: function( event, ui ) {
            $("#category_uuid").val(ui.item.uuid);
		}
	});
    $("#countries").autocomplete({
        source: function (request, response) {
            $.getJSON("{{ route('api.countries.listing', ['query']) }}=" + request.term, function (data) {
                response($.map(data, function (value, key) {
                    return {
                        uuid: value.uuid,
                        cca3: value.cca3,
                        label: value.name_eng_common,
                        value: value.name_eng_common
                    };
                }));
            });
        },
		minLength: 3,
		select: function( event, ui ) {
            $("#country_uuid").val(ui.item.uuid);
		}
	});
});

var map = L.map('map-new').setView([{{ $address->latlng }}], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
L.marker([{{ $address->latlng }}]).addTo(map)
    .bindPopup('{{ $address->name }}')
    .openPopup();
</script>
@endsection