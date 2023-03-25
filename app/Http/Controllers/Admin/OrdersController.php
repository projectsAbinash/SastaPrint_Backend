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
        elseif($request->status == "placed"){
            $data = OrderData::where('status','placed')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "shipped"){
            $data = OrderData::where('status','shipped')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "cancelled"){
            $data = OrderData::where('status','cancelled')->orderBy('created_at', 'desc')->paginate(10);
        }
        elseif($request->status == "delivered"){
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
    
}