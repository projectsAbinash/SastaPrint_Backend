<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\OrderData;
class Dashboard extends Controller
{
    public function DashboardIndex()
    {
        $data['order'] = OrderData::all();
        $data['user'] = user::all();
        $data['employee'] = Employee::count();
        return view('Admins.Dashboard',compact('data'));
    }
}
