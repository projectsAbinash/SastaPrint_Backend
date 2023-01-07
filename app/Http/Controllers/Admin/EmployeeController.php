<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
class EmployeeController extends Controller
{
    public function create()
    {
        $view = 'list';
        return view('Admins.Newemployee',compact('view'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|numeric|digits:10',
            'aadhar' => 'required|numeric|digits:12',
            'profile' => 'image|mimes:jpg,png,jpeg,gif,svg|max:800',
            'password' => 'required|min:6',
            'faadhar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:800',
            'baadhar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:800',
        ]);
        $Employee = Employee::create([
         'name' => $request->name,
         'phone' => $request->phone,
         'password' => $request->password,
        ]);

        $profile = Storage::put('public/Employee/Profiles/pic', $request->file('profile'));
        $faadhar = Storage::put('public/Employee/Profiles/aadhar', $request->file('faadhar'));
        $baadhar = Storage::put('public/Employee/Profiles/aadhar', $request->file('baadhar'));
       

        $Employee->Eprofile()->create([
        'profile_pic' => $profile,
        'adhaar_numbers' => $request->aadhar,
        'adhaar_frontside' => $faadhar,
        'adhaar_backside' => $baadhar,
        ]);
        return back()->with(['success' => 'Employee Registraion SuccessFully']);
    }
}
