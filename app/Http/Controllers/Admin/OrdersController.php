<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderData;
use App\Models\DocumentsData;
use App\Models\OrderActivity;
use Storage;


class OrdersController extends Controller
{
    public function get(Request $request)
    {
        if ($request->status == "All") {
            $data = OrderData::orderBy('created_at', 'desc')->paginate(10);
        }elseif($request->status == "Unpaid"){
            $data = OrderData::where('status','unpaid')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "Processing"){
            $data = OrderData::where('status','processing')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "placed"){
            $data = OrderData::where('status','placed')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "printed"){
            $data = OrderData::where('status','printed')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "Dispatched"){
            $data = OrderData::where('status','dispatched')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "cancelled"){
            $data = OrderData::where('status','cancelled')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "Delivered"){
            $data = OrderData::where('status','delivered')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "search"){
            $data = OrderData::where('order_id',$request->search)->orderBy('created_at', 'desc')->paginate(10); 
        }
       
        $view = 'list';
        return view('Admins.Orders', compact('view', 'data'));
    }
    public function details(Request $request)
    {
        $view = 'details';
        $data = OrderData::find($request->id);
        $data['activity'] = OrderActivity::where('order_id',$data->order_id)->get();
        return view('Admins.Orders', compact('view', 'data'));
    }

    public function download(Request $request)
    {
        $data = DocumentsData::FindorFail($request->id);
        return Storage::download($data->path);
    }
    



    //order manage
    public function orderaccept(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id',
        ]);
      
        $orders = OrderData::where('order_id', $request->order_id);
       
            if ($orders->first()->status == 'placed') {
                OrderActivity::create([
                'emp_id' => null,
                'order_id' => $orders->first()->order_id,
                'log_message' => 'Order Accepted By :- Admin',
                ]);
              
                $orders->update([
                    'status' => 'processing',
                    'is_assigned_admin' => 1,
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
    }

    public function orderprinted(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id',
            'waste_paper' => 'required|numeric|gt:0'
        ]);
        
        $orders = OrderData::where([
            'order_id' => $request->order_id,
           
        ])->update([
                'status' => 'printed',
                'waste_paper' => $request->waste_paper,
            ]);
            OrderActivity::create([
                'emp_id' => null,
                'order_id' => $request->order_id,
                'log_message' => 'Order Printed By :- Admin'
                ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Status Changed To Printed'
        ]);
    }

    public function ordershipped(Request $request)
    {
        $request->validate([
            'link' => 'required',
            'order_id' => 'required|exists:order_data,order_id',
        ]);
      
        OrderData::where([
            'order_id' => $request->order_id,
            'status' => 'printed',
           
        ])->update([
                'status' => 'dispatched',
                'tracking_link' => $request->link,
            ]);
            OrderActivity::create([
                'emp_id' => null,
                'order_id' => $request->order_id,
                'log_message' => 'Order dispatched By :- Admin'
                ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Status Update Successfully'
        ]);
    }
    public function orderdeliverd(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_data,order_id',
        ]);
        
        $orders = OrderData::where([
            'order_id' => $request->order_id,
           
            
        ])->update([
                'status' => 'delivered',
        ]);
            OrderActivity::create([
                'emp_id' => null,
                'order_id' => $request->order_id,
                'log_message' => 'Order Delivered By :- Admin'
                ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Order Updated To Deliverd'
        ]);
    }

}