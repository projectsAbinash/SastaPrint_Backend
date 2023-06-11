<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderData;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmpPapersRequest;
use App\Models\EmpVerficationCodes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Branch;
class EmployeeController extends Controller
{
    public function create()
    {
        $branches = Branch::all();

        return view('Admins.emp.Newemployee',compact('branches'));
    }
    public function verify(Request $request)
    {
        $data = Employee::findOrFail($request->id);
        return view('Admins.emp.verifyemployee', compact('data'));
    }
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'phone' => 'required|numeric|digits:10|unique:employees,phone',
                'aadhar' => 'required|numeric|digits:12',
                'profile' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                'password' => 'required|min:6',
                'faadhar' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                'baadhar' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                'branch' => 'required|exists:branches,id'
            ],
            ([
                'profile.required' => 'Profile Picture Required',
            ])
        );
        $Employee = Employee::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'available_papers' => '0',
            'used_papers' => '0',
            'password' => $request->password,
            'branch' => $request->branch
        ]);

        $profile = Storage::put('public/Employee/Profiles/pic', $request->file('profile'));
        $faadhar = Storage::put('public/Employee/Profiles/aadhar', $request->file('faadhar'));
        $baadhar = Storage::put('public/Employee/Profiles/aadhar', $request->file('baadhar'));


        $Employee->Eprofile()->create([
            'profile_pic' => $profile,
            'adhaar_numbers' => $request->aadhar,
            'adhaar_frontside' => $faadhar,
            'adhaar_backside' => $baadhar,
        ]);

        $this->genarateotp($request->phone, $Employee->id);
        return redirect(route('emp.admin.verify', (['id' => $Employee->id])));
    }

    #genarate new otp function
    private function genarateotp($number, $id)
    {

        $checkotp = EmpVerficationCodes::where('user_id', $id)->latest()->first();
        $now = Carbon::now();
        if ($checkotp && $now->isBefore($checkotp->expire_at)) {
            $otp = $checkotp->otp;
        } else {
            $otp = rand('100000', '999999');
            EmpVerficationCodes::create([
                'user_id' => $id,
                'otp' => $otp,
                'expire_at' => Carbon::now()->addMinute(10)
            ]);
        }



        try {
            $response = Http::withHeaders([
                'authorization' => 'xOTpQMDHq4yr7f0LUKRoW5m6Aaj2GBhE9eIFiS3VsnNbvcCJldXbHwxyhuzWYlgjKNsCfe38nMEVFrOI',
                'accept' => '*/*',
                'cache-control' => 'no-cache',
                'content-type' => 'application/json'
            ])->post('https://www.fast2sms.com/dev/bulkV2', [
                    "variables_values" => $otp,
                    "route" => "otp",
                    "numbers" => $number,
                ]);
            $decode = json_decode($response);
            return response()->json($decode->return);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function verifyotp(Request $request)
    {

        $userid = $request->user_id;

        $otp = $request->otp;
        $checkotp = EmpVerficationCodes::where('user_id', $userid)
            ->where('otp', $otp)->latest()->first();
        $now = Carbon::now();
        if (!$checkotp) {

            return back()->withErrors(['success' => 'Invalid OTP']);

        } elseif ($checkotp && $now->isAfter($checkotp->expire_at)) {
            return back()->withErrors(['success' => 'OTP Has Expired']);
        } else {
            Employee::where('id', $userid)->update(['phone_verified_at' => $now]);
            EmpVerficationCodes::where('user_id', $userid)->delete();
            return redirect(route('Admin.employee.create'))->with(['success' => 'Employee created successfully']);
        }
    }
    public function resendotp(Request $request)
    {
        $data = Employee::findOrFail($request->id);
        if ($this->genarateotp($data->phone, $data->id)) {
            return back()->with(['success' => 'OTP Resend SuccessFully']);
        }
    }

    #get list of employees
    public function emplist()
    {
        $view = 'list';
        $emp = Employee::orderBy('id', 'desc')->get();
        return view('Admins.emp.employeeview', compact('emp', 'view'));
    }

    #get emplayee data 
    public function empget(Request $request)
    {
        $view = 'details';
       
        $emp_id = $request->id;
        $main = Employee::find($emp_id);
        // $orders_data = OrderData::where('assigned_emp', $emp_id);

        $dash['available_papers'] = $main->available_papers;
        $dash['used_papers'] = $main->used_papers;
        $ordscollection = collect(OrderData::where('assigned_emp', $emp_id)->get(['amount', 'status', 'waste_paper']));

        $dash['total_orders'] = $ordscollection->count();
        $dash['total_amount'] = $ordscollection->where('status', 'delivered')->sum('amount');

        $dash['ongoing_orders_data'] = $ordscollection->where('status', 'processing')->count();
        $dash['new_orders_data'] = OrderData::where(['status' => 'placed'])->count();
        $dash['delivered_orders_data'] = $ordscollection->where('status', 'delivered')->count();
        $dash['shipped_orders_data'] = $ordscollection->where('status', 'dispatched')->count();
        $dash['printed'] = $ordscollection->where('status', 'printed')->count();
        $dash['waste_paper'] = $ordscollection->sum('waste_paper');
        return view('Admins.emp.employeeview', compact('view','dash'));
    }


    //check papers req
    public function checkpaperreq()
    {
        $getrow = EmpPapersRequest::orderBy('created_at', 'desc')->where('status', 'pending')->get();
        return view('Admins.papers', compact('getrow'));
    }
    //approve papers
    public function Papersapprove(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'mpin' => 'required'
        ]);
        $check = EmpPapersRequest::where(['order_id' => $request->order_id, 'mpin' => $request->mpin]);

        if ($check->exists()) {
            $check->update(['status' => 'approved']);
            $emp = $check->first();
            Employee::find($emp->user_id)->increment(
                'available_papers', $emp->quantity,
            );
            return response()->json([
                'status' => 'true',
                'message' => 'Order Approved SuccessFully',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Invalid MPIN Entered',
            ]);
        }
    }
    public function rejectpaper(Request $request)
    {
        EmpPapersRequest::find($request->id)->update([
            'status' => 'rejected'
        ]);
        return back()->with(['success' => 'Requst Rejected SuccessFully']);
    }
}