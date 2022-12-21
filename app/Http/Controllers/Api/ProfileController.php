<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class ProfileController extends Controller
{
    public function getprofile(Request $request)
    {
        $profile = User::find($request->user()->id);
        return $profile;
    }
}
