<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Employee extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return $this->name;
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'nik',
        'name',
        'address',
        'phone',
        'email',
        'emergency_name',
        'emergency_phone',
        'join_date',
        'exit_date',
        'note',
        'branch_id',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }
}
