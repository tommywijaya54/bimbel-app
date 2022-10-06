<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Employee extends Model
{
    use HasFactory, HasHistories;

    public function getModelLabel()
    {
        return $this->name;
    }

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

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
