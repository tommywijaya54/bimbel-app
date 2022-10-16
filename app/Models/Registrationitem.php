<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class Registrationitem extends Model
{
    use HasFactory, SoftDeletes, HasHistories;

    public function getModelLabel()
    {
        return '#Registration item : ' . $this->id;
    }

    /*
 protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

protected $fillable = [
        'student_id',
        'branch_id',
        'reference',
        'cashback',
        'status',
        'note'
    ];

    $table->integer('student_id');
        $table->integer('branch_id');
        $table->date('date');
        $table->string('reference');
        $table->integer();
        $table->string('status')->nullable();
        $table->string('note')->nullable();
        */
}
