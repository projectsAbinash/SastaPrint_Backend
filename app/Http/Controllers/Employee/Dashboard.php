<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
class Dashboard extends Controller
{
    public function DashboardIndex()
    {
        $profile = Employee::find(Auth::guard('employee')->user()->id);
        return view('Empdash.dashboard',compact('profile'));
    }
}