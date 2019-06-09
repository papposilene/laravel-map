<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentification
Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => true
]);
  
Route::redirect('/', '/home', 301);
Route::get('home',                              'HomeController@index')->name('home');
  
// Country
Route::get('countries',                         'CountriesController@index')->name('country.index');
Route::get('category/{slug}',                   'CategoriesController@index')->name('category.index');
  
// Administration
Route::middleware('auth')->group(function () {
  // Index
  Route::get('admin',                           'AdminController@index')->name('admin.index');
  
  // Categories
  Route::get('admin/categories/',               'CategoriesController@admin')->name('category.admin');
  Route::get('admin/category/new',              'CategoriesController@create')->name('category.create');
  Route::post('admin/categories/store',         'CategoriesController@store')->name('category.store');
  Route::get('admin/categories/edit/{uuid}',    'CategoriesController@edit')->name('category.edit');
  Route::post('admin/categories/update',        'CategoriesController@update')->name('category.update');
  Route::get('admin/categories/delete',         'CategoriesController@destroy')->name('category.delete');
  Route::get('admin/categories/restore',        'CategoriesController@restore')->name('category.restore');
  
  // Countries
  Route::get('admin/countries',                 'CountriesController@admin')->name('country.admin');
  Route::get('admin/country/new',               'CountriesController@create')->name('country.create');
  Route::post('admin/country/store',            'CountriesController@store')->name('country.store');
  Route::post('admin/countries/update',			'CountriesController@update')->name('country.update');
  Route::get('admin/countries/delete',			'CountriesController@destroy')->name('country.delete');
  Route::get('admin/countries/restore',			'CountriesController@restore')->name('country.restore');
  
  // Addresses
  Route::get('admin/addresses',                 'AddressesController@admin')->name('address.admin');
  Route::post('admin/addresses',                'AddressesController@admin')->name('address.search');
  Route::get('admin/address/new/',              'AddressesController@create')->name('address.create');
  Route::post('admin/address/store',            'AddressesController@store')->name('address.store');
  Route::get('admin/address/edit/{uuid}',       'AddressesController@edit')->name('address.edit');
  Route::post('admin/address/update/',          'AddressesController@update')->name('address.update');
  Route::get('admin/address/delete/',           'AddressesController@destroy')->name('address.delete');
  Route::get('admin/address/restore/',          'AddressesController@restore')->name('address.restore');
  
  // Users
  Route::get('admin/users',				'UsersController@admin')->name('user.admin');
  Route::get('admin/user/new',				'UsersController@create')->name('user.create');
  Route::post('admin/user/store',				'UsersController@store')->name('user.store');
  Route::get('admin/user/update/',				'UsersController@edit')->name('user.edit');
  Route::post('admin/user/update/',				'UsersController@update')->name('user.update');
  Route::get('admin/user/delete/',				'UsersController@destroy')->name('user.delete');
  Route::get('admin/user/restore/',				'UsersController@restore')->name('user.restore');
  
  // Import
  Route::get('admin/import',                    'ImportController@index')->name('import.index');
  Route::post('admin/import',                   'ImportController@import')->name('import.store');
  
  // Export
  Route::get('admin/export',                    'ExportController@index')->name('export.index');
  Route::get('admin/export/addresses/{type}',   'ExportController@addresses')->name('export.addresses')->where('type', '(xlsx|csv|ods)');
  Route::get('admin/export/categories/{type}',  'ExportController@categories')->name('export.categories')->where('type', '(xlsx|csv|ods)');
  Route::get('admin/export/countries/{type}',   'ExportController@countries')->name('export.countries')->where('type', '(xlsx|csv|ods)');
});