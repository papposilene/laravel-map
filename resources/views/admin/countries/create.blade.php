@extends('layouts.admin')
@section('title', @ucfirst(__('app.newCou')))

@section('main')
<div class="row d-flex justify-content-center">
    <h1 class="col-md-6 h2 mb-3">
        <i class="fas fa-map-marked-alt" aria-hidden="true"></i> @ucfirst(__('app.newCou'))
    </h1>
</div>
@if ($errors->any())
<div class="row d-flex justify-content-center">
    <div class="col-md-6 mx-3 alert alert-danger">
        <ol>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
</div>
@endif
<div class="row d-flex justify-content-center" id="countries-list">
    <div class="col-md-6 mb-3">
        <input type="text" class="form-control search mb-3 border-secondary w-100" autocomplete="off" placeholder="@ucfirst(__('app.search'))" />
    </div>
    <div class="w-100"></div>
    <ul class="col-md-6 list list-group list-group-flush">
        @foreach($countries as $country)
        @php
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
        $userCountry = $visited->containsStrict('country_uuid', $country->uuid);
        $nextStatus = (($userCountry === true) ? 'false' : 'true');
        @endphp
        <li class="list-group-item">
            <form action="{{ route('country.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="country_uuid" value="{{ $country->uuid }}" />
                <input type="hidden" name="country_cca3" value="{{ $country->cca3 }}" />
                <input type="hidden" name="user_uuid" value="{{ $currentUser->uuid }}" />
                <span class="badge badge-light badge-pill float-right">
                @if($userCountry)
                    <button type="submit" class="btn btn-sm"><i class="fas fa-trash text-danger" aria-hidden="true"></i></button>
                @else
                    <button type="submit" class="btn btn-sm"><i class="fas fa-map-marker-alt text-success" aria-hidden="true"></i></button>
                @endif
                </span>
                <h2 class="h4 country-name">{{ $country->flag }} {{ $l10nCommon }}</h2>
                <p class="text-left">
                    @ucfirst(__('app.officially')), {{ $l10nOfficial }}.
                    @ucfirst(__('app.localized')) {{ $country->region }} / {{ $country->subregion }}.
                </p>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/list.min.js') }}"></script>
<script type="text/javascript">
var countriesList = new List('countries-list', {
    valueNames: ['country-name']
});
</script>
@endsection