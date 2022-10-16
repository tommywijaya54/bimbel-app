<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Registration extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return '#' . $this->id;
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

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
