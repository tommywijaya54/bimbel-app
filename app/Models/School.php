<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class School extends Model
{
    use
        HasFactory,
        HasHistories;

    public function getModelLabel()
    {
        return $this->name;
    }

    protected $fillable = [
        'name',
        'address',
        'city',
        'type',
        'color_code'
    ];
}
