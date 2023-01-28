<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\DocumentsData;
use Illuminate\Http\Request;
use App\Models\OrderData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class OrderManage extends Controller
{
    
    public function pendinglist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where([
            'status' => 'processing',
            'assigned_emp' => $emp_id,
        ])->get();
        return view('Empdash.orders',compact('data','view'));
    }
    public function completedlist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where([
            'status' => 'delivered',
            'assigned_emp' => $emp_id,
        ])->get();
        return view('Empdash.orders',compact('data','view'));
    }
    public function availablelist()
    {
        $view = 'list';
        $data = OrderData::where('status','placed')->get();
        return view('Empdash.orders',compact('data','view'));
    }
    public function viewmanage(Request $request)
    {
        $view = 'details';
        $data = OrderData::where(['order_id'=> $request->id])->first();
        return view('Empdash.orders', compact('view', 'data'));
    }
    public function download(Request $request)
    {
        $data = DocumentsData::FindorFail($request->id);
        return Storage::download($data->path);
    }
}
