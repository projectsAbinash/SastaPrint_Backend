<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\DocumentsData;
use Illuminate\Http\Request;
use App\Models\OrderData;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderManage extends Controller
{

    public function pendinglist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where('assigned_emp', $emp_id)->whereIn('status', ['shipped', 'processing'])->get();
        return view('Empdash.orders', compact('data', 'view'));
    }
    public function completedlist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where([
            'status' => 'delivered',
            'assigned_emp' => $emp_id,
        ])->get();
        return view('Empdash.orders', compact('data', 'view'));
    }
    public function availablelist()
    {
        $view = 'list';
        $data = OrderData::where('status', 'placed')->get();
        return view('Empdash.orders', compact('data', 'view'));
    }
    public function viewmanage(Request $request)
    {
        $view = 'details';
        $data = OrderData::where(['order_id' => $request->id])->first();
        return view('Empdash.orders', compact('view', 'data'));
    }
    public function download(Request $request)
    {
        $data = DocumentsData::FindorFail($request->id);
        return Storage::download($data->path);
    }

    //for accept orders
    public function orderaccept(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id',
        ]);
        $emp_id = Auth::guard('employee')->user()->id;
        $orders = OrderData::where('order_id', $request->order_id);
        if (
            OrderData::where([
                'assigned_emp' => $emp_id,
                'status' => 'processing',
            ])->exists()
        ) {
            return response()->json([
                'status' => 'false',
                'message' => 'Shipped Previous Orders First'
            ]);
        }

        //check for papers
        $tp = 0;
        $paper = $orders->first()->Userdocs;
        foreach ($paper as $t_pages) {
            $tp += ($t_pages->total_pages * $t_pages->copies_count);
        }

        $emp_data = Employee::find($emp_id);
        if ($emp_data->available_papers >= $tp) {
            $emp_data->decrement('available_papers', $tp);
            $orders->update([
                'status' => 'processing',
                'assigned_emp' => $emp_id,
            ]);

            return response()->json([
                'status' => 'true',
                'message' => 'Order Accepted SuccessFully',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'You Dont Have Enough Papers To Accept This Order',
            ]);
        }
    }

    public function ordershipped(Request $request)
    {
        $request->validate([
            'link' => 'required',
            'order_id' => 'required|exists:order_data,order_id',
        ]);
        $emp_id = Auth::guard('employee')->user()->id;
        OrderData::where([
            'order_id' => $request->order_id,
            'status' => 'processing',
            'assigned_emp' => $emp_id,
        ])->update([
                'status' => 'shipped',
                'traking_link' => $request->link,
            ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Status Update Successfully'
        ]);
    }

    //order delivred
    public function orderdeliverd(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id',
        ]);
        $emp_id = Auth::guard('employee')->user()->id;
        $orders = OrderData::where([
            'order_id' => $request->order_id,
            'assigned_emp' => $emp_id,
        ])->update([
                'status' => 'delivered',
            ]);

            return response()->json([
                'status' => 'true',
                'message' => 'Order Updated To Deliverd'
            ]);
    }
}