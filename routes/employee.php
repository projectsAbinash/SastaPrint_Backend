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
  return redirect(route('emp.login.page'));
});
Route::middleware('emp.guest')->group(function () {
  Route::get('/login', 'Authpage@LoginPage')->name('emp.login.page');
  Route::post('/login/submit', 'Authpage@LoginSubmit')->name('emp.login.submit');
});

Route::middleware('emp.auth')->group(function () {
  Route::get('/Dashboard', 'Dashboard@DashboardIndex')->name('EmpDashboard');

  //for papers management
  Route::get('/Manage/Paper/', 'ManagePapers@index')->name('mngpaper');
  Route::post('/Manage/Paper/Request', 'ManagePapers@request')->name('mngpaper.request');
 
  //for orders managements
  Route::get('/GetLabel/View/{id}', 'OrderManage@GetShippingLabel')->name('shippinglabel');

  Route::get('/Orders/Processing', 'OrderManage@pendinglist')->name('emp.order.processing');
  Route::get('/Orders/Available', 'OrderManage@availablelist')->name('emp.order.available');
  Route::get('/Orders/Completed', 'OrderManage@completedlist')->name('emp.order.completed');

  Route::get('/Orders/Dispatched', 'OrderManage@shippedlist')->name('emp.order.dispatched');
  Route::get('/Orders/Printed', 'OrderManage@printedlist')->name('emp.order.printed');

  Route::get('/Orders/View', 'OrderManage@viewmanage')->name('emp.order.manage');
//order staus
  Route::post('/Orders/Accept', 'OrderManage@orderaccept')->name('emp.order.accept');
  Route::post('/Orders/Shipped', 'OrderManage@ordershipped')->name('emp.order.shipped');
  Route::post('/Orders/Printed', 'OrderManage@orderprinted')->name('emp.order.printed');
  Route::post('/Orders/Deliverd', 'OrderManage@orderdeliverd')->name('emp.order.deliverd');

  Route::get('/Orders/Download/{id}', 'OrderManage@download')->name('emp.order.download');

  Route::get('/logout', 'Authpage@logout')->name('emp.logout');



});