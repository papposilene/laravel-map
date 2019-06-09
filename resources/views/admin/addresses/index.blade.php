@extends('layouts.admin')
@section('title', @ucfirst(__('app.addressesList')))
@section('css-file')
<link rel="stylesheet" href="{{ asset('/css/leaflet.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/leaflet.awesome-markers.min.css') }}" />
@endsection
@section('css-style')
<style>
#map-countries {
height: 175px;
    width: 100%;
}
.faMarker{font-family: FontAwesome; margin-top: 8px;}
</style>
@endsection

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-12 h2 mb-3">
        <i class="far fa-address-book" aria-hidden="true"></i> @ucfirst(__('app.addressesList'))
    </h1>
</div>
@if('status' === 'addOk')
<div class="row d-flex justify-content-center">
    <div class="col-12 alert alert-success" role="alert">
        @ucfirst(__('app.addSuccess'))
    </div>
</div>
@endif
@if('status' === 'delOk')
<div class="row d-flex justify-content-center">
    <div class="col-12 alert alert-danger" role="alert">
        @ucfirst(__('app.delSuccess'))
    </div>
</div>
@endif
<div class="row d-flex justify-content-center">
    <div class="col-12 mb-3">
        <div class="row">
            <div class="col-4">
                <form action="{{ route('address.search') }}" method="POST">
                    @csrf
                    <input type="text" name="search" class="form-control form-control-sm search border-secondary w-100" autocomplete="off" placeholder="@ucfirst(__('app.search'))" />
                </form>
            </div>
            <div class="col-3">
                <select id="category" class="custom-select custom-select-sm border-secondary">
                    <option>@ucfirst(__('app.categoriesList'))</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->uuid }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <select id="country" class="custom-select custom-select-sm border-secondary">
                    <option>@ucfirst(__('app.countriesList'))</option>
                    @foreach($visited as $vCountry)
                    @php
                    $ctrFiltering = $countries->where('uuid', $vCountry->country_uuid);
                    $ctrFiltered = $ctrFiltering->pluck('name_translations')->first();
                    $l18nCountry = json_decode($ctrFiltered, true);
                    if(array_key_exists($currentLocale, $l18nCountry))
                    {
                        $l10nCommon = $l18nCountry[$currentLocale]['common'];
                        $l10nOfficial = $l18nCountry[$currentLocale]['official'];
                    }
                    else
                    {
                        $l10nCommon = $vCountry->name_eng_common;
                        $l10nOfficial = $vCountry->name_eng_official;
                    }
                    @endphp
                    <option value="{{ $vCountry->country_uuid }}">{{ $l10nCommon }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 text-right">
                <a href="{{ route('address.create') }}" class="btn btn-sm btn-primary">@ucfirst(__('app.newAdd'))</a>
                @isset($query['deleted'])
                <a href="{{ route('address.admin') }}" class="btn btn-sm btn-outline-success"><i class="fas fa-history" aria-hidden="true"></i></a>
                @else
                <a href="{{ route('address.admin', ['deleted' => 1]) }}" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash" aria-hidden="true"></i></a>
                @endisset
            </div>
        </div>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="row d-flex justify-content-center">
        <nav aria-label="@ucfirst(__('app.navigation'))">
            {{ $addresses->links() }}
        </nav>
    </div>
</div>
<div class="row px-4 d-flex justify-content-center">
    @foreach($addresses->chunk(3) as $addChunck)
    <div class="card-deck">
        @foreach($addChunck as $address)
        @php
        $deleted = (isset($address->deleted_at) ? ' border-danger' : '');
        $filterngCat = $categories->whereStrict('uuid', $address->category_uuid);
        $filteredCat = $filterngCat->first();
        $filterngCtr = $countries->whereStrict('uuid', $address->country_uuid);
        $filteredCtr = $filterngCtr->first();
        @endphp
        <div class="card border-light{{ $deleted }}  mb-3">
            <div class="h5 card-header">
                <span class="badge badge-light badge-pill float-right">
                    <a href="{{ route('address.edit', ['uuid' => $address->uuid]) }}" class="text-info"><i class="fas fa-edit" aria-hidden="true"></i></a> |
                    @isset($address->deleted_at)
                    <a href="{{ route('address.restore', ['uuid' => $address->uuid]) }}" class="text-success"><i class="fas fa-trash-restore" aria-hidden="true"></i></a>
                    @else
                    <a href="{{ route('address.delete', ['uuid' => $address->uuid]) }}" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i></a>
                    @endisset
                </span>
                <i class="fas fa-{{ $filteredCat->icon }}" aria-hidden="true"></i> {{ $address->name }}
            </div>
            <div class="card-body">
                <p class="text-justify">
                    <a href="{{ route('address.admin', ['category' => $filteredCat->uuid]) }}" class="text-dark">
                    <i class="fas fa-{{ $filteredCat->icon }}" aria-hidden="true"></i> {{ $filteredCat->name }}
                    </a><br />
                    {{ $filteredCtr->flag }}&nbsp;{{ $address->address }}, 
                    <a href="{{ route('address.admin', ['country' => $filteredCtr->cca3]) }}" class="text-dark">{{ $filteredCtr->name_eng_common }}</a>.<br /><br />
                    @isset($address->url)
                    <i class="fas fa-link"></i> <a href="{{ $address->url }}" class="text-dark" target="_blank" rel="noopener">@ucfirst(__('app.website'))</a>.<br />
                    @endisset
                    @isset($address->phone)
                    <i class="fas fa-phone"></i> <a href="tel:{{ $address->phone }}" class="text-dark" target="_blank" rel="noopener">{{ $address->phone }}</a>.<br />
                    @endisset
                    <i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps/search/?api=1&query={{ $address->latlng }}" class="text-dark" target="_blank" rel="noopener">{{ $address->latlng }}</a>.
                </p>
                <p class="text-justify">
                    {{ $address->description }}
                </p>
            </div>
            <div class="card-footer text-right">
                <small class="text-muted"><em>
                    {{ __('app.createdat', ['date' => $address->created_at->format('d/m/Y, H:i:s')]) }}.<br />
                    {{ __('app.updatedat', ['date' => $address->updated_at->format('d/m/Y, H:i:s')]) }}.<br />
                    @isset($address->deleted_at)
                    {{ __('app.deletedat', ['date' => $address->deleted_at->format('d/m/Y, H:i:s')]) }}.
                    @endisset
                </em></small>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
<div class="row d-flex justify-content-center">
    <div class="row d-flex justify-content-center">
        <nav aria-label="@ucfirst(__('app.navigation'))">
            {{ $addresses->links() }}
        </nav>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$('select#category').change(function(e){
    var category = $("select#category option:selected").val();
    @php
    $isCountry = (isset($query['country']) ? '?country=' . $query['country'] . '&' : '?');
    $isDeleted = (isset($query['deleted']) ? '&deleted=' . $query['deleted'] . '&' : '');
    @endphp
    window.location.href = "{!! url()->current() !!}{!! $isCountry !!}{!! $isDeleted !!}category=" + category;
});
$('select#country').change(function(e){
    var country = $("select#country option:selected").val();
    @php
    $isCategory = (isset($query['category']) ? '?category=' . $query['category'] . '&' : '?');
    $isDeleted = (isset($query['deleted']) ? '&deleted=' . $query['deleted'] . '&' : '');
    @endphp
    window.location.href = "{!! url()->current() !!}{!! $isCategory !!}{!! $isDeleted !!}country=" + country;
});
</script>
@endsection