<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Seshac\Shiprocket\Shiprocket;



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



        //fetch pin code
        try {
            $response = Http::get('https://api.postalpincode.in/pincode/' . $request->pincode);

            $decode = json_decode($response);
            $token =  Shiprocket::getToken();
           
           
           
            if (isset($decode[0]->PostOffice[0])) {
                $pincodeDetails = [
                    'pickup_postcode' => 422007,
                    'delivery_postcode' => $request->pincode,
                    'weight' => 2,
                    'cod' => 0
                 ];
                 
                 $shiprocket =  Shiprocket::courier($token)->checkServiceability($pincodeDetails);
                
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
