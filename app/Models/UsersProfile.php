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
        return asset(Storage::url($value));

    }
}
