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
Route::middleware('emp.guest')->group(function () {
    Route::get('/login', 'Authpage@LoginPage')->name('emp.login.page');
    Route::post('/login/submit', 'Authpage@LoginSubmit')->name('emp.login.submit');
  });

Route::middleware('emp.auth')->group(function () {
  Route::get('/Dashboard', 'Dashboard@DashboardIndex')->name('EmpDashboard');
  Route::get('/logout', 'Authpage@logout')->name('emp.logout');
});


