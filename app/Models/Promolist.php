<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Promolist extends Model
{
    use HasFactory, HasHistories;

    public function getModelLabel()
    {
        return $this->label;
    }

    protected $fillable = [
        'label', 'branch_id', 'start_date', 'end_date', 'discount_value'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
