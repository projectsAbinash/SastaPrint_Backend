<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\DocumentsData;
use Illuminate\Http\Request;
use App\Models\OrderData;
use App\Models\Employee;
use App\Models\OrderActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderManage extends Controller
{

    public function pendinglist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where('assigned_emp', $emp_id)->whereIn('status', ['processing'])->get();
        return view('Empdash.orders', compact('data', 'view'));
    }

    public function shippedlist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where('assigned_emp', $emp_id)->whereIn('status', ['dispatched'])->get();
        return view('Empdash.orders', compact('data', 'view'));
    }

    public function printedlist()
    {
        $emp_id = Auth::guard('employee')->user()->id;
        $view = 'list';
        $data = OrderData::where('assigned_emp', $emp_id)->whereIn('status', ['printed'])->get();
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
            ])->count() >= '20'
        ) {
            return response()->json([
                'status' => 'false',
                'message' => 'Dispatched Previous Orders First'
            ]);
        }

        //check for papers
        $tp = 0;
        $paper = $orders->first()->Userdocs;
        foreach ($paper as $t_pages) {
            if ($t_pages->page_config == 'two_side') {
                $tp += ceil($t_pages->total_pages / 2) * $t_pages->copies_count;

            } else {
                $tp += ($t_pages->total_pages * $t_pages->copies_count);
            }
        }


        $emp_data = Employee::find($emp_id);
        if ($emp_data->available_papers >= $tp) {
            if ($orders->first()->status == 'placed') {
                OrderActivity::create([
                'emp_id' => $emp_id,
                'order_id' => $orders->first()->order_id,
                'log_message' => 'Order Accepted By :- '.$emp_data->name.' , Phone Number :- '.$emp_data->phone.' , Branch : - '.ucfirst($emp_data->branch)
                ]);
                $emp_data->decrement('available_papers', $tp);
                $emp_data->increment('used_papers', $tp);
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
                    'message' => 'Order Accepted By Someone',
                ]);
            }

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
        $emp_data = Employee::find($emp_id);
        OrderData::where([
            'order_id' => $request->order_id,
            'status' => 'printed',
            'assigned_emp' => $emp_id,
        ])->update([
                'status' => 'dispatched',
                'tracking_link' => $request->link,
            ]);
            OrderActivity::create([
                'emp_id' => $emp_id,
                'order_id' => $request->order_id,
                'log_message' => 'Order Dispatched By :- '.$emp_data->name.' , Phone Number :- '.$emp_data->phone.' , Branch : - '.ucfirst($emp_data->branch)
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
        $emp_data = Employee::find($emp_id);
        $orders = OrderData::where([
            'order_id' => $request->order_id,
            'assigned_emp' => $emp_id,
        ])->update([
                'status' => 'delivered',
            ]);
            OrderActivity::create([
                'emp_id' => $emp_id,
                'order_id' => $request->order_id,
                'log_message' => 'Order Delivered By :- '.$emp_data->name.' , Phone Number :- '.$emp_data->phone.' , Branch : - '.ucfirst($emp_data->branch)
                ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Updated To Deliverd'
        ]);
    }

    public function orderprinted(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id',
            'waste_paper' => 'required|numeric|gt:0'
        ]);
        $emp_id = Auth::guard('employee')->user()->id;
        $emp_data = Employee::find($emp_id);
        $orders = OrderData::where([
            'order_id' => $request->order_id,
            'assigned_emp' => $emp_id,
        ])->update([
                'status' => 'printed',
                'waste_paper' => $request->waste_paper,
            ]);
            OrderActivity::create([
                'emp_id' => $emp_id,
                'order_id' => $request->order_id,
                'log_message' => 'Order Printed By :- '.$emp_data->name.' , Phone Number :- '.$emp_data->phone.' , Branch : - '.ucfirst($emp_data->branch)
                ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Status Changed To Printed'
        ]);
    }
}