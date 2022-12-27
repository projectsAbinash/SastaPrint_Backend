<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnCallback;

class OrdersController extends Controller
{
    public function get()
    {
        $view = 'list';
        return view('Admins.Orders',compact('view'));
    }
    public function details()
    {
        $view = 'details';
       return view('Admins.Orders',compact('view'));
    }
}
