<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderData;

class Dashboard extends Controller
{
    public function DashboardIndex()
    {
        // $orders = OrderData::where('')
        $emp_id = Auth::guard('employee')->user()->id;
        $main = Employee::find($emp_id);
        // $orders_data = OrderData::where('assigned_emp', $emp_id);

        $dash['available_papers'] = $main->available_papers;
        $dash['used_papers'] = $main->used_papers;
        $dash['total_orders'] = OrderData::where('assigned_emp', $emp_id)->count();
        $dash['total_amount'] = OrderData::where([
            'assigned_emp' => $emp_id,
            'status' => 'delivered'
        ])->sum('amount');
        $dash['ongoing_orders_data'] = OrderData::where(['status' => 'processing', 'assigned_emp' => $emp_id])->count();
        $dash['new_orders_data'] = OrderData::where(['status' => 'placed'])->count();
        $dash['delivered_orders_data'] = OrderData::where(['status' => 'delivered', 'assigned_emp' => $emp_id])->count();
        $dash['shipped_orders_data'] = OrderData::where(['status' => 'shipped', 'assigned_emp' => $emp_id])->count();
        $dash['printed'] = OrderData::where(['status' => 'printed', 'assigned_emp' => $emp_id])->count();
        $dash['waste_paper'] = OrderData::where(['assigned_emp' => $emp_id])->sum('waste_paper');
        return view('Empdash.dashboard', compact('dash'));
    }
}