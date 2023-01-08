<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserAddress;
use Illuminate\Http\Request;

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
            'PinCode' => 'required|digits:6',
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

        
         // if(true)
        // {
        //     return response()->json([
        //         'status' => 'false',
        //         'message' => 'This Pin Code Is Not Serviceable',
        //         ]
        //     );
        // }


        //fetch pin code
        try {
            $response = Http::get('https://api.postalpincode.in/pincode/' . $request->pincode);
            $decode = json_decode($response);
            if (isset($decode[0]->PostOffice[0])) {
                foreach($decode[0]->PostOffice as $item)
                {
                    $city[] = $item->Name;
                }
                return response()->json([
                    'city' => $city,
                    //'data' => $decode[0],
                    'state' => $decode[0]->PostOffice[0]->State,
                    'status' => 'true',
                ]);
            }else{
                return response()->json([
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
