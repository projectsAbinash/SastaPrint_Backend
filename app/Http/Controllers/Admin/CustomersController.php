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
    return view('Admins.Customers', compact('view', 'list'));
  }
  public function Details(Request $request)
  {
    $data = User::find($request->id);
    $view = 'details';
    return view('Admins.Customers', compact('view', 'data'));
  }
  public function blocked(Request $request)
  {
    if ($request->Action == 'Deactive') {
      User::find($request->id)->UserBlocked()->create([
        'reasons' => 'You Have Been Blocked By Admin',
      ]);
      return back()->with(['success' => 'User Deactivated SuccessFully']);
    }
    if ($request->Action == 'Active') {
      User::find($request->id)->UserBlocked()->delete();
      return back()->with(['success' => 'User Activated SuccessFully']);
    }

  }
}
