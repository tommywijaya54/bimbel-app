<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cparent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'address',
        'phone',
        'email',
        'birth_date',
        'emergency_name',
        'emergency_phone',
        'bank_account_name',
        'virtual_account_name',
        'note',
        'blacklist'
    ];

    protected $hidden = [
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
