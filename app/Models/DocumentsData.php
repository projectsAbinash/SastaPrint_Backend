<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsData extends Model
{
    use HasFactory;
    protected $guarded = ['id'];   
    public function Getorder()
    {
        return $this->hasOne(OrderData::class, 'order_id', 'order_id');
    }
}
