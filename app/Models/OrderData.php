<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    use HasFactory;
    protected $table = 'order_data';
    protected $guarded = ['id'];  
    public function Userdocs()
    {
        return $this->hasMany(DocumentsData::class, 'order_id', 'order_id');
    } 
    public function Getuser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
   
}
