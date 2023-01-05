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

Route::post('/register', 'ApiAuth@RegisterUser');
Route::post('/login', 'ApiAuth@LoginUser');

Route::middleware('auth:sanctum', 'cotp')->group(function () {
    #for auths
    Route::post('/otp/resend', 'ApiAuth@resend')->withoutMiddleware('cotp');
    Route::post('/login/verifyotp', 'ApiAuth@verifyotp')->withoutMiddleware('cotp');
    Route::post('/home/banners', 'HomeController@GetBanners');
    #for profile
    Route::post('/profile', 'ProfileController@getprofile');
    Route::post('/profile/update', 'ProfileController@UpdateProfile');
    #for address
    Route::post('/profile/Address', 'AddressController@Get');
    Route::post('/profile/Address/New', 'AddressController@New');
    Route::post('/profile/Address/Delete', 'AddressController@Delete');


    #for orders Route
    Route::post('/Orders/UploadDoc/', 'OrdersController@UploadDoc');
    Route::post('/Orders/UploadDoc/Update', 'OrdersController@AddNewdoc');
    Route::post('/Orders/UploadDoc/Removed', 'OrdersController@DocRemoved');
    Route::post('/Orders/Place/', 'OrdersController@PlaceOrder');
    Route::post('/Orders/GetbyId/', 'OrdersController@GetOrder');
    Route::post('/Orders/list/', 'OrdersController@orderlist');

    #for payment route
    Route::post('/Orders/PaymentStart/', 'RazorPayController@BuyNow');
    Route::post('/Orders/PaymentStart/Callback', 'RazorPayController@Callback');
    
});
//Route::get('/Orders/PaymentStart/Callback', 'RazorPayController@Callback');