<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppNotification;
use OneSignal;

class NotifiacationController extends Controller
{
    public function new(Request $request)
    {
        $getlist = AppNotification::orderby('id','desc')->paginate(10);
        return view('Admins.notification',compact('getlist'));
    }
    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);

        OneSignal::sendNotificationToAll(
            $request->message,
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null,
            $request->title,
        );
        AppNotification::create([
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'true'
        ]);
        return back()->with(['success' => 'Message Has Been Sent SuccessFully']);
    }
}
