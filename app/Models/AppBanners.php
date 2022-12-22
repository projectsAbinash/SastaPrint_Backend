<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppBanners extends Model
{
    use HasFactory;
    protected $guarded = ['id'];   
    public function getSrcAttribute($value)
    {
        return asset(Storage::url($value));

    }
}
