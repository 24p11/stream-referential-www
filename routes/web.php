<?php
use App\Concept;
use App\Http\Resources\Concept as ConceptResource;
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


Route::get('concept', 'ConceptController@index');

Route::get('/api', function () {
    return ConceptResource::collection(Concept::all());
});
