<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class EmployeeController extends CommonController
{

    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,nik:NIK,name:Employee Name,phone,branch_id',
            'form' =>  '
                    nik:NIK,,
                    name,
                    address,
                    phone,
                    email,
                    emergency_name,
                    emergency_phone,
                    join_date,
                    exit_date,
                    note,
                    branch_id,
                    password:User login password,
                    roles'
        ], true);

        $this->form->title_format = "{nik} / {name}";
        $this->form->field('password')->extrafield = true;

        $exceptRole = ['Owner', 'super-admin', 'Parent', 'Student'];
        $employee_only_role = array_values(array_diff(Role::pluck('name')->toArray(), $exceptRole));

        $this->form->field('roles')->hasOptions(
            $employee_only_role,
            'multiple-checkbox'
        );

        $this->form->field('roles')->value = [];
        $this->form->field('roles')->extrafield = true;

        $controller = $this;
        $this->form->field('roles')->getValue = function ($field, $id) use ($controller) {
            return $controller->entity::find($id)->user->getRoleNames();
        };

        $this->form->beforeRender['create'] = function ($renderData) {
            $renderData['form_schema']->field('roles')->value = ['Employee'];
            return $renderData;
        };

        $this->form->beforeRender['edit'] = function ($renderData) {
            $renderData['form_schema']->field('password')->required = false;
            return $renderData;
        };
    }

    public function show($id)
    {
        $form = $this->form->displayForm($id);
        $roles = $form->entity_item->user->roles->pluck('name');

        return Inertia::render('Employee/Show', [
            'title' => $form->title,
            'form_schema' => $form,
            'roles' => $roles,
            'salaries' => $form->entity_item->salaries->toArray(),
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

    public function add_salary($id, Request $request)
    {
        $employee = Employee::find($id);
        $employee->salaries()->create([
            'start_date' => $request->start_date,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);
    }

    public function delete_salary($id, $salary_id)
    {
        $employee = Employee::find($id);
        $item = $employee->salaries()->find($salary_id);
        $item->delete();
    }
}
