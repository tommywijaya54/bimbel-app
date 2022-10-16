<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Pricelist extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return $this->subject;
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

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
