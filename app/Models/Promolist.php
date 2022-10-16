<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Promolist extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return $this->label;
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'label', 'branch_id', 'start_date', 'end_date', 'discount_value'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
