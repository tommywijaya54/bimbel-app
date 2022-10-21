<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class RegistrationItem extends Model
{
    use HasFactory, SoftDeletes, HasHistories;


    public function getModelLabel()
    {
        return '#Registration item : ' . $this->id;
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
