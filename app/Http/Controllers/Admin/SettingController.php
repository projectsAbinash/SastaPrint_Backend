<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
   public function setareaindex()
   {
    return view('Admins.setting');
   }
   public function setarea(Request $request)
   {
   return $request->all();
   }
}
