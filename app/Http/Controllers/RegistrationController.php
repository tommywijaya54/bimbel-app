<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FormSchema;
use App\ListSchema;
use App\Models\Branch;
use App\Models\Registration;
use App\Models\School;
use App\Models\Student;
use Inertia\Inertia;
use PHPUnit\Framework\MockObject\Builder\Stub;

class RegistrationController extends CommonController
{
    function __construct()
    {
        $this->init([
            'list' => 'id,date,student_id,branch_id,status',
            'form' => 'date,,student_id,branch_id,reference,cashback::number,status,note'
        ], true);
    }
}
