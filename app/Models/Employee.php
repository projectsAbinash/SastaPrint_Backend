<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'phone',
        'password',
        'available_papers',
        'used_papers',
        'branch'
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function Eprofile()
    {
        return $this->hasOne(EmployeeProfile::class, 'user_id', 'id');
    }
    public function PaperRequ()
    {
        return $this->hasMany(EmpPapersRequest::class, 'user_id', 'id')->orderBy('id', 'desc')
        ;
    }
    public function GetBranchName()
    {
        return $this->hasOne(Branch::class, 'id', 'branch');
    }
    
}
