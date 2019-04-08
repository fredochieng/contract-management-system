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
    Route::any('contract/{id}/publish', 'ContractController@publish');
    Route::any('submit', 'ContractController@submit');
    Route::any('ammend', 'ContractController@ammend');
    Route::any('terminate', 'ContractController@terminate');
    Route::any('approve', 'ContractController@approve');
    Route::resource('admin/party', 'PartyController');
    Route::any('contract/{id}/view', 'ContractController@viewcontract');

});