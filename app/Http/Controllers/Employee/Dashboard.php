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
        $main = Employee::find(Auth::guard('employee')->user()->id);
        $dash['available_papers'] = $main->available_papers;
        return view('Empdash.dashboard',compact('dash'));
    }
}
