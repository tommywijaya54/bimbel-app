<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Schedule extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return '#Schedule : ' . $this->id;
    }
}
