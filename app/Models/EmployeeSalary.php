<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class EmployeeSalary extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'start_date',
        'amount',
        'note',
    ];

    public function getModelLabel()
    {
        return '#Salary : ' . $this->id;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
