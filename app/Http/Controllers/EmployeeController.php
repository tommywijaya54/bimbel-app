<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmployeeController extends CommonController
{

    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,nik:NIK,name:Employee Name,phone,branch_id',
            'form' =>  'nik:NIK,,name,address,phone,email,emergency_name,emergency_phone,join_date,exit_date,note,branch_id,password:User login password,roles'
        ], true);

        $this->form->title_format = "{nik} / {name}";
        $this->form->field('password')->extrafield = true;

        $this->form->field('roles')->hasOptions(
            ['Branch Manager', 'Advisor', 'Teacher', 'HRD', 'Finance'],
            'multiple-checkbox'
        );
        $this->form->field('roles')->value = [];
        $this->form->field('roles')->extrafield = true;

        $controller = $this;
        $this->form->field('roles')->getValue = function ($field, $id) use ($controller) {
            //dd($this->entity::find($id));
            return $controller->entity::find($id)->user->getRoleNames();
        };
    }

    public function show($id)
    {
        $form_data = $this->form->displayForm($id);

        $employee_details = $this->entity::with('user', 'branch')->find($id);
        $roles = $employee_details->user->roles->pluck('name');

        return Inertia::render('Employee/Show', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            // 'employee_details' => $employee_details,
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:employees',
            'name' => 'required',
            'email' => 'required|unique:users',
            'branch_id' => 'required',
            'password' => 'required',
            'roles' => 'required',
        ]);

        $controller = $this;
        DB::transaction(
            function () use ($controller, $request) {
                $employee = $controller->entity::create($controller->form->setStoreOrUpdate($request));

                $user = User::firstOrNew(['email' =>  $request['email']]);
                $user->name = $request['name'];
                $user->type = 'Employee';
                $user->password = bcrypt($request['password']);
                $user->save();
                $user->syncRoles($request->roles);

                $employee->user_id = $user->id;
                $employee->update();
            }
        );
        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $employee = $this->entity::find($id);

        $request->validate([
            'nik' => 'required|unique:employees,nik,' . $id,
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $employee->user_id,
            'branch_id' => 'required',
            'roles' => 'required',
        ]);

        $controller = $this;
        DB::transaction(function () use ($controller, $request, $id, $employee) {
            $controller->form->setStoreOrUpdate($request, $controller->entity::find($id))->update();

            $user = User::find($employee->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            if (isset($request->password)) {
                $user->password = bcrypt($request['password']);
            }
            $user->update();

            $user->syncRoles($request->roles);
        });

        return redirect('/' . $this->modal . '/' . $id);
    }
}
