<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class BranchExpense extends Model
{
    use HasFactory, HasHistories, SoftDeletes;

    public function getModelLabel()
    {
        return $this->expense_type . ' ' . $this->amount;
    }

    protected $fillable = [
        'date',
        'expense_type',
        'description',
        'amount'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
