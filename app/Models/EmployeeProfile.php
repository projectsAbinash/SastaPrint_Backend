<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmployeeProfile extends Model
{
    use HasFactory;
    protected $guarded = ['id'];   
    public function getProfilePicAttribute($value)
    {
        if($value != null)
        return asset(Storage::url($value));
        else
        return asset('AdminAssets/Source/assets/img/user_default.png');

    }
}
