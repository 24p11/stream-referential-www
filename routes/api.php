<?php


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

Route::prefix('v1')->group(function () {
    Route::get('/referential/{referential}', 'Api\V1\ReferentialController@referential');
    Route::get('/referential/list/{referential}', 'Api\V1\ReferentialListController@referentialList');
    Route::get('/referential/relationship/{referential}', 'Api\V1\ReferentialRelationshipController@referentialRelationship');

    Route::get('/metadata_dictionary', 'Api\V1\MetadataDictionaryController@dictionaries');
    Route::get('/metadata_dictionary/{referential}', 'Api\V1\MetadataDictionaryController@dictionary');
    Route::put('/metadata_dictionary/{metadata_dictionary}', 'Api\V1\MetadataDictionaryController@update');

    Route::get('/list_dictionary', 'Api\V1\ListDictionaryController@dictionaries');
    Route::get('/list_dictionary/{referential}', 'Api\V1\ListDictionaryController@dictionary');
    Route::put('/list_dictionary/{list_dictionary}', 'Api\V1\ListDictionaryController@update');

});

