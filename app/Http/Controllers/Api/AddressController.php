<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
            'Address_Type' => 'required|in:Home,Work',
            'Alternate_number' => 'number|digits:10',

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
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Address Added SuccssFully',
        ]);
    }
}
