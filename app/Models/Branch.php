<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Branch extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return $this->name;
    }


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
        return $this->belongsTo(User::class, 'manager_id'); //User::find($this->manager_id);
    }

    /*
    public function user()
    {
        return User::find($this->manager_id);
    }
    */


    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function assets()
    {
        return $this->hasMany(BranchAsset::class, 'branch_id', 'id');
    }

    public function rentals()
    {
        return $this->hasMany(BranchRental::class, 'branch_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(BranchExpense::class, 'branch_id', 'id');
    }
}
