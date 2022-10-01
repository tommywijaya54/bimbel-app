<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promolist extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'branch_id', 'start_date', 'end_date', 'discount_value'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
