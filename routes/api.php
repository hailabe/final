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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@details');
});




Route::apiResources(['salesstaff' => 'API\SalesstaffController']);
Route::get('searchstaff','API\SalesstaffController@search');
Route::get('searchstafflist','API\SalesstaffController@list');

Route::apiResources(['producer' => 'API\ProducerController']);
Route::get('searchproducer','API\ProducerController@search');

Route::apiResources(['artist' => 'API\ArtistController']);
Route::get('searchartist','API\ArtistController@search');

Route::apiResources(['album' => 'API\AlbumController']);
Route::get('searchalbum','API\AlbumController@search');
    

