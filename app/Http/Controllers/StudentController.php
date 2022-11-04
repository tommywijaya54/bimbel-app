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
            'form' => 'name,address,phone,email,birth_date,health_condition,_,
                    type,,school_id,grade,_,
                    cparent_id:Parent,_,
                    join_date,exit_date|nr,note|nr,exit_reason|nr,_,password:Password for user login|nr'
        ], true);

        $this->form->title_format = '{name}';

        $this->form->field('grade')->hasOptions(
            ['TKA', 'TKB', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
            'select'
        );

        $this->form->field('cparent_id')->route['show'] = 'parent.show';


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

                $user->syncRoles('Student');

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
            if (isset($request['password']) && $request['password'] != null) {
                $user->password = bcrypt($request['password']);
            }
            $user->update();

            $user->syncRoles('Student');
        });

        return redirect('/' . $this->modal . '/' . $id);
    }
}
