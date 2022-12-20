<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

use Hash;
class AuthController extends Controller
{
    public function LoginPage()
    {
        return view('Admins.Auth.Login');
    }
    public function LoginSubmit(Request $request)
    {
      $validated = $request->validate([
        'username' => 'required',
        'password' => 'required',
       ]);
        // return Admin::create([
        //     'name' => 'Clickerr Education Admin',
        //     'username' => $request->username,
        //     'name' => 'Sasta Print Admin',
        //     'password' =>  Hash::make($request->password),
        // ]);
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password],$request->remember)) {
            $request->session()->regenerate();
            return redirect(route('DashboardIndex'));
        }
        return back()->withErrors(['msg' => 'Oppes! You have entered invalid credentials']);
    }
    public function demo()
    {
        return "Hello You Are Already Logged In";
    }
    public function logout(Request $request)
    {
       // Session::flush();

        Auth::guard('admin')->logout();
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect(route('Admin.Login.Page'))->with('success','You Have Been Logged out SuccessFully');
    }
}
