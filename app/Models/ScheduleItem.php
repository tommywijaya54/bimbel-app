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
        'start_at',
        'end_at'
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