<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppNotification extends Model
{
    use HasFactory;
    protected $table = 'app_notification';
    protected $guarded = ['id'];   
    
}
