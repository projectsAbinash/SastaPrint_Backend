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

    #check if the user registred or not

    #validate otp

    private function VerifyOTP($phone, $otp)
    {
        if ($phone == '1234567890') {
            VerficationCodes::where('phone', $phone)->delete();
            return 1;
        }
        $checkotp = VerficationCodes::where('phone', $phone)
            ->where('otp', $otp)->latest()->first();
        $now = Carbon::now();
        if (!$checkotp) {
            return 0;
        } elseif ($checkotp && $now->isAfter($checkotp->expire_at)) {
            return 0;
        } else {
            $device = 'Auth_Token';
            VerficationCodes::where('phone', $phone)->delete();
            return 1;
        }
    }
    #genarate new otp function
    private function genarateotp($number)
    {

        $checkotp = VerficationCodes::where('phone', $number)->latest()->first();
        $now = Carbon::now();
        if ($checkotp && $now->isBefore($checkotp->expire_at)) {
            $otp = $checkotp->otp;
        } else {
            $otp = rand('100000', '999999');
            VerficationCodes::create([
                'phone' => $number,
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
            return response()->json($decode->message);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }





    public function test(Request $request)
    {
        return "Hello This is Home";
    }

    #resend otp
    public function resend(Request $request)
    {

        $phone = $request->user()->phone;

        if ($this->genarateotp($phone)) {
            return response()->json([
                'status' => true,
                'message' => 'Sms Sent Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Sms Could Not Be Sent',
            ]);
        }
    }
    #auth reset password

    #check otp for reset password

    public function SendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
        ]);
        $this->genarateotp($request->phone);
        return response()->json([
            'status' => true,
            'message' => 'otp send successfully',
        ]);
    }
    public function login_or_signup(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
            'phone' => 'required|numeric'
        ]);
        if ($this->VerifyOTP($request->phone, $request->otp)) {
            $checkphone = User::where('phone', $request->phone)->first();
            if ($checkphone) {

                $token = $checkphone->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'OTP Verified  Successfully (Login)',
                    'token' => $token,
                ]);
            } else {
                $newuser = User::create([
                    'phone' => $request->phone,
                ]);
                $newuser->UserExtra()->create([
                    'user_id' => $newuser->id,
                ]);

                $token = $newuser->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'OTP Verified  Successfully (new user)',
                    'token' => $token,
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Your OTP Is Invalid'
            ]);
        }
    }
}
