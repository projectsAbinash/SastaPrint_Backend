<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VerficationCodes;

//models list
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApiAuth extends Controller
{

    #validate otp

    public function verifyotp(Request $request)
    {
        $userid = $request->user()->id;
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);
        $checkotp = VerficationCodes::where('user_id', $userid)
            ->where('otp', $request->otp)->latest()->first();
        $now = Carbon::now();
        if (!$checkotp) {
            return response()->json([
                'status' => 'false',
                'message' => 'Your OTP Is Invalid'
            ]);
        } elseif ($checkotp && $now->isAfter($checkotp->expire_at)) {
            return response()->json([
                'status' => 'false',
                'message' => 'Your OTP Has Expired'
            ]);
        } else {
            User::find($userid)->update(['phone_verified_at' => $now]);
            VerficationCodes::where('user_id', $userid)->delete();
            return response()->json([
                'status' => 'true',
                'message' => 'Your OTP Has Verified SuccessFully'
            ]);
        }
    }
    #genarate new otp function
    private function genarateotp($number, $id)
    {

        $checkotp = VerficationCodes::where('user_id', $id)->latest()->first();
        $now = Carbon::now();
        if ($checkotp && $now->isBefore($checkotp->expire_at)) {
            $otp = $checkotp->otp;
        } else {
            $otp = rand('100000', '999999');
            VerficationCodes::create([
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


    public function RegisterUser(Request $request)
    {

        $request->validate([
            'name' => 'required|max:100',
            'email' => 'max:100|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);



        $newuser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);
        $newuser->UserExtra()->create([
            'user_id' => $newuser->id,

        ]);
        $token = $newuser->createToken('auth_token')->plainTextToken;
        #sending An OTP To Verify User




        $userid = $newuser->id;
        $this->genarateotp($request->phone, $userid);


        #return token to user
        return response()->json([
            'status' => 'true',
            'access_token' => $token,
            'verification' => $newuser->phone_verified_at == null ? 'false' : 'true',
            'message' => 'Registration Successfully',
        ]);
    }

    public function LoginUser(Request $request)
    {
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 'true',
                'access_token' => $token,
                'verification' => $request->user()->phone_verified_at == null ? 'false' : 'true',
                'message' => 'Logged In Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Invalid Credentials',
            ]);
        }
    }
    public function test(Request $request)
    {
        return "Hello This is Home";
    }

    #resend otp
    public function resend(Request $request)
    {
        $userid = $request->user()->id;
        $phone = $request->user()->phone;

        if ($this->genarateotp($phone, $userid)) {
            return response()->json([
                'status' => 'true',
                'message' => 'Sms Sent Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Sms Could Not Be Sent',
            ]);
        }
    }
}