<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmpVerficationCodes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
class EmployeeController extends Controller
{
    public function create()
    {
       
        return view('Admins.emp.Newemployee');
    }
    public function verify(Request $request)
    {
       $data = Employee::findOrFail($request->id);
        return view('Admins.emp.verifyemployee',compact('data'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|numeric|digits:10|unique:employees,phone',
            'aadhar' => 'required|numeric|digits:12',
            'profile' => 'image|mimes:jpg,png,jpeg,gif,svg|max:800',
            'password' => 'required|min:6',
            'faadhar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:800',
            'baadhar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:800',
        ]);
        $Employee = Employee::create([
         'name' => $request->name,
         'phone' => $request->phone,
         'available_papers' => '0',
         'password' => $request->password,
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
        return redirect(route('emp.admin.verify',(['id' => $Employee->id])));
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
            Employee::where('id',$userid)->update(['phone_verified_at' => $now]);
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
       $emp = Employee::orderBy('id','desc')->get();
        return view('Admins.emp.employeeview',compact('emp','view'));
     }

     #get emplayee data 
     public function empget(Request $request)
     {
        $view = 'details';
        $emp = Employee::find($request->id);
         return view('Admins.emp.employeeview',compact('emp','view'));
     }
}
