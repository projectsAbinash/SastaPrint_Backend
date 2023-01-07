<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authpage extends Controller
{
    public function LoginPage()
    {
        return view('Empdash.Auth.Login');
    }
    public function LoginSubmit(Request $request)
    {
      $validated = $request->validate([
        'phone' => 'required',
        'password' => 'required',
       ]);
        // return Admin::create([
        //     'name' => 'Clickerr Education Admin',
        //     'username' => $request->username,
        //     'name' => 'Sasta Print Admin',
        //     'password' =>  Hash::make($request->password),
        // ]);
        if (Auth::guard('employee')->attempt(['phone' => $request->phone, 'password' => $request->password],$request->remember)) {
            $request->session()->regenerate();
            return redirect(route('EmpDashboard'));
        }
        return back()->withErrors(['msg' => 'Oppes! You have entered invalid credentials']);
    }
    public function logout(Request $request)
    {
       // Session::flush();

        Auth::guard('employee')->logout();
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect(route('emp.login.page'))->with('success','You Have Been Logged out SuccessFully');
    }
}
