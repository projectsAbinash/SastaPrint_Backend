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
    Route::post('/otp/resend', 'ApiAuth@resend')->withoutMiddleware('cotp');
    Route::post('/login/verifyotp', 'ApiAuth@verifyotp')->withoutMiddleware('cotp');
    Route::post('/home/banners' , 'HomeController@GetBanners');
    Route::post('/profile' , 'ProfileController@getprofile');
    Route::post('/profile/update' , 'ProfileController@UpdateProfile');
    Route::post('/profile/Address' , 'AddressController@Get');
    Route::post('/profile/Address/New' , 'AddressController@New');
});







