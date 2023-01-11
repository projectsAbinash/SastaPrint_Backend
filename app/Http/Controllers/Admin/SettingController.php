<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setarea;

class SettingController extends Controller
{
   public function setareaindex()
   {
      $addedlist = Setarea::all();
      $requestlist = Setarea::orderBy('count','desc');
      
      return view('Admins.setting',compact('addedlist','requestlist'));
   }
   public function setarea(Request $request)
   {
      $request->validate([
         'pin' => 'required|digits:6',
      ]);
      $response = Http::get('https://api.postalpincode.in/pincode/' . $request->pin);
      $decode = json_decode($response);
      Setarea::create([
         'pincode' => $request->pin,
         'state' => $decode[0]->PostOffice[0]->State,
         'status' => 'added',
      ]);
      return back()->with(['success'=>'PinCode Added SuccessFully']);
   }
  
}
