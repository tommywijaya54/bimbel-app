<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Student extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return $this->name;
    }

    protected $fillable = [
        'name',
        'grade',
        'address',
        'phone',
        'email',
        'join_date',
        'exit_date',
        'note',
        'exit_reason',
        'birth_date',
        'type',
        'health_condition',
        'cparent_id',
        'school_id'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function cparent()
    {
        return $this->belongsTo(Cparent::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
