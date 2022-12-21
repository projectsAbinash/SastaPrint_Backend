<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppBanners;
class HomeController extends Controller
{
   public function GetBanners()
   {
   $banners = AppBanners::all();
   return response()->json([
    'banners' => $banners,
   ]);
   }
}
