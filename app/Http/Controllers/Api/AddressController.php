<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\Setarea;

class AddressController extends Controller
{
    public function Get(Request $request)
    {


        $get = User::find($request->user()->id);

        return response()->json([
            'status' => 'true',
            'data' => $get->UserAddress,
        ]);
    }

    public function New(Request $request)
    {
        $request->validate([
            'Address_1' => 'required',
            'Address_2' => 'required',
            'City' => 'required',
            'PinCode' => 'required|numeric|digits:6',
            'State' => 'required',
            'Address_Type' => 'required|in:Home,Work,Other',
            'Alternate_number' => 'numeric|digits:10',

        ]);
        $new = User::find($request->user()->id);
        $new->UserAddress()->create([
            'Address_1' => $request->Address_1,
            'Address_2' => $request->Address_2,
            'Landmark' => $request->Landmark,
            'City' => $request->City,
            'PinCode' => $request->PinCode,
            'State' => $request->State,
            'Address_Type' => $request->Address_Type,
            'Alternate_number' => $request->Alternate_number,
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Address Added SuccssFully',
        ]);
    }
    public function Delete(Request $request)
    {
        UserAddress::find($request->id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'Address Deleted SuccessFully',
        ]);
    }
    public function getpin(Request $request)
    {

        $request->validate([
            'pincode' => 'required|numeric|digits:6'
        ]);

        $token =  \Seshac\Shiprocket\Shiprocket::getToken();
        return $token;

        //fetch pin code
        try {
            $response = Http::get('https://api.postalpincode.in/pincode/' . $request->pincode);

            $decode = json_decode($response);
            if (isset($decode[0]->PostOffice[0])) {
                $shiprocket = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaXYyLnNoaXByb2NrZXQuaW4vdjEvZXh0ZXJuYWwvYXV0aC9sb2dpbiIsImlhdCI6MTY5NDI0MzQ2NCwiZXhwIjoxNjk1MTA3NDY0LCJuYmYiOjE2OTQyNDM0NjQsImp0aSI6ImhlREpEUW9xeEt4azJQcHEiLCJzdWIiOjM0MDIwMjMsInBydiI6IjA1YmI2NjBmNjdjYWM3NDVmN2IzZGExZWVmMTk3MTk1YTIxMWU2ZDkifQ.isGmR8HKEWy_yjQZRPWrAtFmpF9hBqG9Mj_RDg6J-RY'
                ])->get('https://apiv2.shiprocket.in/v1/external/courier/serviceability/?pickup_postcode=422007&delivery_postcode=' . $request->pincode . '&cod=0&weight=2');
                $shiprocket = json_decode($shiprocket);
                foreach ($decode[0]->PostOffice as $item) {
                    $city[] = $item->Name;
                }
                $state = $decode[0]->PostOffice[0]->State;
                if (!isset($shiprocket->status) && $shiprocket->status == 200) {

                    return response()->json(
                        [
                            'status' => 'false',
                            'message' => 'This Pin Code Is Not Serviceable',
                        ]
                    );
                } else {
                    return response()->json([
                        'city' => $city,
                        //'data' => $decode[0],
                        'state' => $state,
                        'status' => 'true',
                    ]);
                }
            } else {
                return response()->json(
                    [
                        'status' => 'false',
                        'message' => 'This Pin Code Is Invalid',
                    ]
                );
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function fetchpin(Request $request)
    {
        $request->validate([
            'pincode' => 'required|numeric|digits:6'
        ]);


        //fetch pin code
        try {
            $response = Http::get('https://api.postalpincode.in/pincode/' . $request->pincode);


            $decode = json_decode($response);
            if (isset($decode[0]->PostOffice[0])) {
                foreach ($decode[0]->PostOffice as $item) {
                    $city[] = $item->Name;
                }
                $state = $decode[0]->PostOffice[0]->State;
                $district = $decode[0]->PostOffice[0]->District;


                return response()->json([
                    'city' => $city,
                    //'data' => $decode[0],
                    'state' => $state,
                    'district' => $district,
                    'status' => 'true',
                ]);
            } else {
                return response()->json(
                    [
                        'status' => 'false',
                        'message' => 'This Pin Code Is Invalid',
                    ]
                );
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
