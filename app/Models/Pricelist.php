<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Pricelist extends Model
{
    use HasFactory, HasHistories;

    public function getModelLabel()
    {
        return $this->subject;
    }

    protected $fillable = [
        'branch_id',
        'end_date',
        'level',
        'price',
        'school_type',
        'start_date',
        'subject',
        'week',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
