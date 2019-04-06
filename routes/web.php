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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('admin/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::any('admin/party/get_party', 'PartyController@get_party');
    Route::resource('admin/contract', 'ContractController');
    Route::any('contract/{id}/submit', 'ContractController@submit');
    Route::any('approve', 'ContractController@approve');
    Route::any('reject', 'ContractController@reject');
    Route::resource('admin/party', 'PartyController');
    Route::any('contract/{id}/view', 'ContractController@viewcontract');

});