<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UsersProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
    public function getPicAttribute($value)
    {
        if($value != null)
        return asset(Storage::url($value));
        else
        return asset('AdminAssets/Source/assets/img/user_default.png');

    }
}
