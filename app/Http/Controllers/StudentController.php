<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class StudentController extends CommonController
{
    public $entity = Student::class;
    public $modal = 'student';

    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name:Student Name,grade,phone,email',
            'form' => 'name,grade,address,phone,email,join_date,exit_date,note,exit_reason,birth_date,type,health_condition,cparent_id:Parent,school_id,password:User login password'
        ], true);

        $this->form->title_format = '{name}';

        $this->form->field('grade')->hasOptions(
            ['TKA', 'TKB', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
            'select'
        );

        $this->form->field('password')->extrafield = true;
    }

    public function store(Request $request)
    {
        $request->validate([
            'cparent_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'school_id' => 'required',
            'password' => 'required',
        ]);

        $controller = $this;
        DB::transaction(
            function () use ($controller, $request) {
                $student = $controller->entity::create($controller->form->setStoreOrUpdate($request));

                $user = User::firstOrNew(['email' =>  $request['email']]);
                $user->name = $request['name'];
                $user->type = 'Student';
                $user->password = bcrypt($request['password']);
                $user->save();

                $student->user_id = $user->id;
                $student->update();
            }
        );

        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $student = $this->entity::find($id);

        $request->validate([
            'cparent_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $student->user_id,
            'school_id' => 'required',
        ]);

        $controller = $this;

        DB::transaction(function () use ($controller, $request, $id, $student) {
            $controller->form->setStoreOrUpdate($request, $controller->entity::find($id))->update();
            $user = User::find($student->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            if (isset($request->password)) {
                $user->password = bcrypt($request['password']);
            }
            $user->update();
        });

        return redirect('/' . $this->modal . '/' . $id);
    }
}
