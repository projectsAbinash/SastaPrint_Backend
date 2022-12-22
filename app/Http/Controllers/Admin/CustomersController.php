<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
   public function GetList()
   {
    $view = 'List';
    $list = User::all();
    return view('Admins.Customers',compact('view','list'));
   }
   public function Details(Request $request)
   {
     $data = User::find($request->id);
     $view = 'details';
     return view('Admins.Customers',compact('view','data'));
   }

}
