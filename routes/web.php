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
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::any('/party/get_party', 'PartyController@get_party');
    Route::resource('contract', 'ContractController');
    Route::any('my-contracts', 'ContractController@mycontracts');
    Route::any('approved-contracts', 'ContractController@approvedContracts');
    Route::any('contract/{id}/publish', 'ContractController@publish');
    Route::any('submit', 'ContractController@submit');
    Route::any('ammend', 'ContractController@ammend');
    Route::any('terminate', 'ContractController@terminate');
    Route::any('approve', 'ContractController@approve');
    Route::resource('/party', 'PartyController');
    Route::any('contract/{id}/view', 'ContractController@viewcontract');
    Route::resource('/user', 'AdminController');



});
