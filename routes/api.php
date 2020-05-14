<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/referential/{referential}', 'Api\V1\ReferentialController@referential');
    Route::get('/referential/list/{referential}', 'Api\V1\ReferentialListController@referentialList');
    Route::get('/referential/relationship/{referential}', 'Api\V1\ReferentialRelationshipController@referentialRelationship');

    Route::get('/referential/metadata_dictionary', 'Api\V1\MetadataDictionaryController@dictionaries');
    Route::get('/referential/metadata_dictionary/{referential}', 'Api\V1\MetadataDictionaryController@dictionary');
    Route::put('/referential/metadata_dictionary/{metadata_dictionary}', 'Api\V1\MetadataDictionaryController@update');
});

