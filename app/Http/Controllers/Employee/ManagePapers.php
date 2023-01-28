<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\EmpPapersRequest;
use App\Models\Employee;
class ManagePapers extends Controller
{
    public function index()
    {
        $data = Employee::find(Auth::guard('employee')->user()->id);
        return view('Empdash.mngpaper',compact('data'));
    }
    public function request(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric',
        ]);
        $data = Employee::find(Auth::guard('employee')->user()->id);
        $mpin = rand(100000, 999999);
        if($data->PaperRequ()->where('status','pending')->exists())
        {
            return back()->withErrors(['success' => 'You Have Already Requsted For Papers, Kindly Wait For Status Update.']);
        }
        $data->PaperRequ()->create([
            
            'order_id' => 'SSTPPR' . rand('10000000', '99999999'),
            'mpin' => $mpin,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);
        return back()->with(['success' => 'Papers Request SuccessFully And Waiting For Approval. And Your MPIN is '.$mpin]);
    }
}