<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'open_date',
        'status',
        'manager_id',
    ];


    public function manager()
    {
        return User::find($this->manager_id);
    }
}
