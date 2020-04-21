<?php

use Illuminate\Support\Facades\Auth;
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
    return view('firsthome');
});

Route::get('admin/login', function () {
    return view('auth.admin-login');
});

Route::get('/springboard', function () {
    return view('springboard');
});

Route::get('/cart', function () {
    return view('cart');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('users/logout', 'Auth\LoginController@userlogout')->name('user.logout');

Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminloginController@showLoginform')->name('admin.login');
    Route::post('/login', 'Auth\AdminloginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminloginController@adminlogout')->name('admin.logout');
    
});
Route::prefix('salesstaffhome')->group(function(){
    Route::get('/login', 'Auth\SalesstaffloginController@showLoginform')->name('salesstaff.login');
    Route::post('/login', 'Auth\SalesstaffloginController@login')->name('salesstaff.login.submit');
    Route::get('/', 'SalesBasiccontroller@index')->name('salesstaff.dashboard');
    Route::get('/logout', 'Auth\SalesstaffloginController@salesstafflogout')->name('salesstaff.logout');
    
});
Route::prefix('artisthome')->group(function(){
    Route::get('/login', 'Auth\ArtistloginController@showLoginform')->name('artist.login');
    Route::post('/login', 'Auth\ArtistloginController@login')->name('artist.login.submit');
    Route::get('/', 'ArtistBasiccontroller@index')->name('artist.dashboard');
    Route::get('/logout', 'Auth\artistloginController@artistlogout')->name('artist.logout');
    
});
Route::prefix('producerhome')->group(function(){
    Route::get('/login', 'Auth\ProducerloginController@showLoginform')->name('producer.login');
    Route::post('/login', 'Auth\ProducerloginController@login')->name('producer.login.submit');
    Route::get('/', 'ProducerBasiccontroller@index')->name('producer.dashboard');
    Route::get('/logout', 'Auth\ProducerloginController@producerlogout')->name('producer.logout');
    
});
Route::get('/{any}','AdminController@index')->where(' any', '.*');