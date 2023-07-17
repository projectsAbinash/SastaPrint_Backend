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

        $emp_id = Auth::guard('employee')->user()->id;
        $main = Employee::find($emp_id);

        $dash['available_papers'] = $main->available_papers;
        $dash['used_papers'] = $main->used_papers;


        $ordscollection = collect(OrderData::where('assigned_emp', $emp_id)->get(['amount', 'status', 'waste_paper','delivery_charge']));

        $dash['total_orders'] = $ordscollection->count();
        $dash['total_amount'] = $ordscollection->where('status', 'delivered')->sum('amount');

        $dash['ongoing_orders_data'] = $ordscollection->where('status', 'processing')->count();
        $dash['new_orders_data'] = OrderData::where(['status' => 'placed'])->count();
        $dash['delivered_orders_data'] = $ordscollection->where('status', 'delivered')->count();
        $dash['shipped_orders_data'] = $ordscollection->where('status', 'dispatched')->count();
        $dash['printed'] = $ordscollection->where('status', 'printed')->count();
        $dash['waste_paper'] = $ordscollection->sum('waste_paper');
        $dash['shipping_cost'] = $ordscollection->where('status', 'delivered')->sum('delivery_charge');
        return view('Empdash.dashboard', compact('dash'));
    }
}
