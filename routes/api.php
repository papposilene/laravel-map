<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    // Addresses
    Route::get('addresses/list',            'API\AddressesController@listing')->name('api.addresses.listing');
    Route::get('addresses/geojson/point',   'API\AddressesController@point')->name('api.addresses.point');
    
    // Categories
    Route::get('categories/list',           'API\CategoriesController@json')->name('api.categories.listing');
    
    // Countries
    Route::get('countries/list',	'API\CountriesController@listing')->name('api.countries.listing');
    Route::get('countries/geojson/point',	'API\CountriesController@point')->name('api.countries.point');
    Route::get('countries/geojson/polygon',	'API\CountriesController@polygon')->name('api.countries.polygon');
    
    Route::get('country/{country_uuid}/geojson/point',	'API\CountriesController@point')->name('api.country.listing');
});