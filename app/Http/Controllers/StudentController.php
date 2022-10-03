<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends CommonController
{
    public $entity = Student::class;
    public $modal = 'student';

    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name:Student Name,grade,phone,email',
            'form' => 'name,grade,address,phone,email,join_date,exit_date,note,exit_reason,birth_date,type,health_condition,cparent_id:Parent,school_id'
        ], true);

        $this->form->field('grade')->hasOptions(
            ['TKA', 'TKB', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
            'select'
        );
    }

    public function store(Request $request)
    {
        $student = $this->entity::create($this->form->setStoreOrUpdate($request));

        $user = User::firstOrNew(['email' =>  $request('email')]);
        $user->name = request('name');
        $user->type = 'Student';
        $user->password = bcrypt('password');
        $user->save();

        $student->user_id = $user->id;
        $student->update();

        return redirect('/' . $this->modal);
    }
}
