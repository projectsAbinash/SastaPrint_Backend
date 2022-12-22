<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppBanners;
use Illuminate\Support\Facades\Storage;


class Banners extends Controller
{
   public function GetList()
   {
     
      $getall = AppBanners::all();
      return view('Admins.Banners',compact('getall'));
   }
   public function upload(Request $request)
   {

      $image_path = Storage::put('public/Users/Banners', $request->file('banner'));
      AppBanners::create([
      'Name' => $request->name,
      'href' => $request->action,
      'src' => $image_path,

      ]);
      return back()->with('success','Banner Uploaded SuccessFully');
   }
   public function delete(Request $request)
   {
      AppBanners::find($request->id)->delete();
      return back()->with('success','Banner Deleted SuccessFully');
   }
}
