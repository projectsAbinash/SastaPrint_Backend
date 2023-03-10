<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpPapersRequest extends Model
{
    protected $guarded = ['id'];
    protected $table = 'emp_papers_request';
    use HasFactory;
    public function Getemp()
    {
        return $this->hasOne(Employee::class, 'id', 'user_id');
    }
}
