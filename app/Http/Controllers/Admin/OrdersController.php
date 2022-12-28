<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderData;
use function PHPUnit\Framework\returnCallback;

class OrdersController extends Controller
{
    public function get()
    {
        $data = OrderData::all();
        $view = 'list';
        return view('Admins.Orders',compact('view','data'));
    }
    public function details()
    {
        $view = 'details';
       return view('Admins.Orders',compact('view'));
    }
}
