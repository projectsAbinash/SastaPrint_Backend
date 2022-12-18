<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect(route('Admin.Login.Page'));
});


//guest routes
Route::middleware('admin.guest')->group(function () {
  Route::get('/login', 'AuthController@LoginPage')->name('Admin.Login.Page');
  Route::post('/login/submit', 'AuthController@LoginSubmit')->name('Admin.Login.Submit');
});

//protected Auth Routes
Route::middleware('admin.auth')->group(function () {
  Route::get('/Dashboard', 'Dashboard@DashboardIndex')->name('DashboardIndex');
  Route::get('/logout', 'AuthController@logout')->name('Admin.logout');
});