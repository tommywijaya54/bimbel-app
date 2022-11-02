<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Attendance extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'reason',
        'present',
        'teacher_id',
        'student_id',
        'schedule_item_id'
    ];

    public function getModelLabel()
    {
        return '#Schedule : ' . $this->id;
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(ScheduleItem::class);
    }
}
