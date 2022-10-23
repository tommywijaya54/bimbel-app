<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Schedule extends Model
{
    use HasFactory, SoftDeletes, HasHistories;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'class_subject',
        'class_room',
        'teacher_id',
        'branch_id',
        'students',
        'week'
    ];

    public function getModelLabel()
    {
        return '#Schedule : ' . $this->id;
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(ScheduleItem::class);
    }
}
