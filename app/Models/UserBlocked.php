<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlocked extends Model
{
    use HasFactory;
    protected $table = "user_blocked";
    protected $guarded = [ "id" ];
}
