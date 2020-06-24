<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::prefix('admin')->group(function () {
    Route::permanentRedirect('/', '/admin/referential');

    Route::get('/referential', function () {
        return view('admin.referential.index');
    });

    Route::get('/list', 'Admin\ReferentialController@list')->name('admin.list');

    Route::get('/manage/{referential}', 'Admin\ReferentialController@manage')->name('admin.manage');
    Route::match(['get', 'put'], '/edit/{referential}', 'Admin\ReferentialController@edit');
    Route::get('/metadata_dictionary/{referential}', 'Admin\ReferentialController@metadataDictionary');
    Route::get('/list_dictionary/{referential}', 'Admin\ReferentialController@listDictionary');
    Route::get('/details/{referential}', 'Admin\ReferentialController@details');
});

