<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class ScheduleItem extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'schedule_id',
        'session_date',
        'session_start_time',
        'session_end_time'
    ];

    public function getModelLabel()
    {
        return '#Schedule item : ' . $this->id;
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
