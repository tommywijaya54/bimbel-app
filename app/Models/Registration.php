<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Registration extends Model
{
    use HasFactory, HasHistories;

    public function getModelLabel()
    {
        return '#' . $this->id;
    }

    protected $fillable = [
        'student_id',
        'branch_id',
        'date',
        'reference',
        'cashback',
        'status',
        'note'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
