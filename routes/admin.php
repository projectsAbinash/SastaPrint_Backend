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

  Route::get('/Customers/List', 'CustomersController@GetList')->name('CustomerList');
  Route::get('/Customers/Details/{id}', 'CustomersController@Details')->name('CustomeDetails');
  Route::get('/Customers/Blocked/{Action}/{id}', 'CustomersController@blocked')->name('Customerblocked');


  Route::get('/Banners/List', 'Banners@GetList')->name('Bannerslist');
  Route::post('/Banners/List', 'Banners@upload')->name('Bannersupload');
  Route::get('/Banners/Delete/{id}', 'Banners@delete')->name('Bannersdelete');

  #for notification routs
  Route::get('/Notificaions', 'NotifiacationController@new')->name('Admin.notification');
  Route::post('/Notificaions/Send', 'NotifiacationController@send')->name('notification.post');

  //orderpanel
  Route::get('/Orders', 'OrdersController@get')->name('Admin.orders');
  Route::get('/Orders/details/{id}', 'OrdersController@details')->name('orders.details');

  Route::get('/logout', 'AuthController@logout')->name('Admin.logout');
});
