<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function getprofile(Request $request)
    {
        $profile = User::find($request->user()->id);
        return response()->json([
            'user_main' => $profile,
            'user_extra' => $profile->UserExtra()->first(),
        ]);
    }
    public function UpdateProfile(Request $request)
    {
        $request->validate([
            'pic' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email',
            'dob' => 'date_format:d/m/Y',
            'gender' => 'in:Male,Female,Other',
            'student' => 'in:true,false',
            'Year' => 'digits:1|in:1,2,3,4,5',
            //'' => '',


        ]);
        $main = User::find($request->user()->id);
        $main->update([
            'email' => $request->email,
            'name' => $request->name,
        ]);

      
        if($request->hasFile('pic'))
        {
              $image_path = Storage::put('public/Users/Profiles', $request->file('pic'));
              $main->UserExtra()->update([
                'pic' => $image_path,
              ]);
        }
      

        $main->UserExtra()->update([
            'gender' => $request->gender,
            'dob' => $request->dob,
            'student' => $request->student,
            'Collage_Name' => $request->Collage_Name,
            'Course' => $request->Course,
            'Year' => $request->Year,
            'Semester' => $request->Semester,
            'occupation' => $request->occupation,
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'Updated SucessFully',
        ]);
    }
}
