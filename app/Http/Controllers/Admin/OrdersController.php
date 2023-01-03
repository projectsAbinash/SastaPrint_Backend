<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderData;
use App\Models\DocumentsData;
use Storage;


class OrdersController extends Controller
{
    public function get()
    {
        $data = OrderData::all();
        $view = 'list';
        return view('Admins.Orders', compact('view', 'data'));
    }
    public function details(Request $request)
    {
        $view = 'details';
        $data = OrderData::find($request->id);
        return view('Admins.Orders', compact('view', 'data'));
    }

    public function download(Request $request)
    {
        $data = DocumentsData::FindorFail($request->id);
        return Storage::download($data->path);
    }
    
}