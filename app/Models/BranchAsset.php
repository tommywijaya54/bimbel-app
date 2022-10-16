<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class BranchAsset extends Model
{
    use HasFactory, HasHistories, SoftDeletes;

    public function getModelLabel()
    {
        return $this->expense_type . ' ' . $this->amount;
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'purchase_date',
        'item_name',
        'qty',
        'cost',
        'note'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
