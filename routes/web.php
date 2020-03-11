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
    return view('welcome');
});

Route::get('/springboard', function () {
    return view('springboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('admin/login', 'Auth\AdminloginController@showLoginform')->name('admin.login');
Route::post('admin/login', 'Auth\AdminloginController@login')->name('admin.login.submit');
Route::get('admin/', 'AdminController@index')->name('admin.dashboard');