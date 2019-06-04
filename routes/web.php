<?php
use Illuminate\Support\Facades\Artisan;

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



Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index');
Route::get('/user/verify/{token}', 'UserController@verifyUser');

Route::group(['middleware' => 'verified'], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::any('/party/get_party', 'PartyController@get_party');
    Route::any('contract-party/{id}/view-contract-party', 'PartyController@contractParty');
    Route::resource('contract', 'ContractController');
    Route::any('pending-contracts', 'ContractController@pendingContracts');
    Route::any('deleted-contracts', 'ContractController@deletedContracts');
    Route::any('classify-contract', 'ContractController@classifyContract');
    Route::any('share-reviewed-contract', 'ContractController@shareReviewedContract');
    Route::any('comment-reviewed-contract', 'ContractController@commentReviewedContract');
    Route::any('share-final-draft', 'ContractController@shareFinalDraft');
    Route::any('comment-final-draft', 'ContractController@commentFinalDraft');
    Route::any('upload-caf-document', 'ContractController@uploadCAF');
    Route::any('approve-caf', 'ContractController@approveCAF');
    Route::any('upload-approved-caf', 'ContractController@uploadApprovedCAF');
    Route::any('close-contract', 'ContractController@closeContract');
    Route::any('reviewed-contracts', 'ContractController@reviewedContracts');
    Route::resource('system/settings', 'SystemController');
    Route::any('add-entity', 'SystemController@storeEntities');
    Route::any('profile', 'UserController@getUserProfile');



    Route::any('my-contracts', 'ContractController@mycontracts');
    Route::any('created-contracts', 'ContractController@createdContracts');
    Route::any('delete-contract/{contract}', 'ContractController@deleteCreatedContract');
    Route::any('my-assigned-contracts', 'ContractController@myAssignedContracts');
    Route::any('approved-contracts', 'ContractController@approvedContracts');
    Route::any('amended-contracts', 'ContractController@ammendedContracts');
    Route::any('terminated-contracts', 'ContractController@terminatedContracts');
    Route::any('closed-contracts', 'ContractController@closedContracts');
    Route::any('work-on-contract', 'ContractController@workonContract');
    Route::any('assign', 'ContractController@assignContract');
    Route::any('transfer-contract', 'ContractController@transferContract');
    Route::any('publish-contract', 'ContractController@publish');
    Route::any('ammend', 'ContractController@ammend');
    Route::any('terminate', 'ContractController@terminate');
    Route::any('upload-signed-contract', 'ContractController@uploadSignedContract');
    Route::any('archive-contract', 'ContractController@archiveContract');
    Route::any('approve', 'ContractController@approve');
    Route::resource('/party', 'PartyController');
    Route::any('contract/{id}/view', 'ContractController@viewcontract');
    Route::resource('/system-users/users', 'UserController');
    Route::any('delete-user', 'UserController@deleteUser');
    Route::any('update-profile/{user}', 'UserController@updateUserProfile');
    Route::resource('/reports', 'ReportController');
    Route::get('reports/{type}/view', 'ReportController@show');
});
