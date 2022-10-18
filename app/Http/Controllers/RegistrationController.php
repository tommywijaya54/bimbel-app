<?php

namespace App\Http\Controllers;

class RegistrationController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,date,student_id,branch_id,status',
            'form' => 'date,,student_id,branch_id,reference,cashback,status,note'
        ], true);

        // $this->form->title_format = '{student.name}'
        $this->form->field('cashback')->inputtype = 'currency';
    }
}
