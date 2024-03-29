<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
  Route::get('/Orders/Action/{status}', 'OrdersController@get')->name('Admin.orders');
  Route::get('/Orders/details/{id}', 'OrdersController@details')->name('orders.details');
  Route::get('/Orders/Documents/Download/{id}', 'OrdersController@download')->name('orders.doc.download');

  //order manage
  Route::controller(OrdersController::class)->prefix('Orders')->group(
    function () {
      Route::post('Accept', 'orderaccept')->name('admin.order.accept');
      Route::post('Shipped', 'ordershipped')->name('admin.order.shipped');
      Route::post('Printed', 'orderprinted')->name('admin.order.printed');
      Route::post('Deliverd', 'orderdeliverd')->name('admin.order.deliverd');
    }
  );
  //end order manage


  //route for employees
  Route::get('/Employee/New', 'EmployeeController@create')->name('Admin.employee.create');
  Route::get('/Employee/list', 'EmployeeController@emplist')->name('admin.emp.list');
  Route::get('/Employee/list/view/{id}', 'EmployeeController@empget')->name('admin.emp.get');
  Route::post('/Employee/New', 'EmployeeController@register')->name('Admin.employee.register');
  Route::get('/Employee/verify/{id}', 'EmployeeController@verify')->name('emp.admin.verify');
  Route::get('/Employee/New/reotp/{id}', 'EmployeeController@resendotp')->name('emp.resend.otp');
  Route::post('/Employee/verify', 'EmployeeController@verifyotp')->name('emp.admin.otpverify');

  //route for employee papers
  Route::get('/Employee/Papersreq', 'EmployeeController@checkpaperreq')->name('Admin.employee.paperreq');
  Route::post('/Employee/Papersapprove', 'EmployeeController@Papersapprove')->name('Admin.employee.Papersapprove');
  Route::get('/Employee/Paperreject/{id}', 'EmployeeController@rejectpaper')->name('Admin.employee.rejectpaper');
  //route for setting
  Route::get('/Setting/Area', 'SettingController@setareaindex')->name('admin.setaddress');
  Route::post('/Setting/Area', 'SettingController@setarea')->name('admin.setaddress.post');
  Route::get('/logout', 'AuthController@logout')->name('Admin.logout');


  Route::controller(BranchController::class)->prefix('Branch')->group(function () {
    Route::get('/List','BranchList')->name('BranchList');
    Route::get('/Create','BranchCreate')->name('BranchCreate');
    Route::post('/Create','BranchSubmit')->name('BranchSubmit');
  });
});
