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
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::any('/party/get_party', 'PartyController@get_party');
    Route::any('contract-party/{id}/view-contract-party', 'PartyController@contractParty');
    Route::resource('contract', 'ContractController');
    Route::any('my-contracts', 'ContractController@mycontracts');
    Route::any('pending-contracts', 'ContractController@pendingContracts');
    Route::any('approved-contracts', 'ContractController@approvedContracts');
    Route::any('ammended-contracts', 'ContractController@ammendedContracts');
    Route::any('terminated-contracts', 'ContractController@terminatedContracts');
    Route::any('work-on-contract', 'ContractController@workonContract');
    Route::any('assign', 'ContractController@assignContract');
    Route::any('contract/{id}/publish', 'ContractController@publish');
    Route::any('ammend', 'ContractController@ammend');
    Route::any('terminate', 'ContractController@terminate');
    Route::any('approve', 'ContractController@approve');
    Route::resource('/party', 'PartyController');
    Route::any('contract/{id}/view', 'ContractController@viewcontract');
    Route::resource('/system-users/users', 'AdminController');
});