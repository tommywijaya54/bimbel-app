<?php

namespace App\Http\Controllers;

use App\CommonSchema;
use App\FormSchema;
use App\Models\Branch;
use App\Models\Cparent;
use App\Models\Employee;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class UserController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name,email,type',
            'form' => 'name,email,type,status|nr,password:|ex|nr,disabled:Deactivation Reason|nr,roles:|ex|nr'
        ], true);

        $this->form->title_format = '{name}';
        $this->form->field('type')->hasOptions([
            'Employee', 'Student', 'Parent'
        ], 'select');

        $this->form->field('roles')->hasOptions(
            Role::pluck('name')->toArray(),
            'multiple-checkbox'
        );

        $this->form->field('roles')->getValue = function ($field, $id) {
            return User::find($id)->getRoleNames();

            // $user = User::with('roles')->find($id);
            // return $user->roles
        };

        // Support Form Field
        $this->student_form = new CommonSchema('name,birth_date,type,grade,email,phone,address,,join_date,exit_date,health_condition,exit_reason,note');
        $this->employee_form = new CommonSchema('nik,,name,email,phone,,address,note,join_date,exit_date,_,emergency_name,emergency_phone,branch_id');
        $this->parent_form = new CommonSchema('nik,blacklist,name,email,phone,birth_date,address,note,emergency_name,emergency_phone,bank_account_name,virtual_account_name');
    }


    public function show($id)
    {
        $form_data = $this->form->displayForm($id);
        $user = $this->entity::find($id);

        return Inertia::render('User/Show', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            'student_form_fields' => $this->student_form->fields,
            'employee_form_fields' => $this->employee_form->fields,
            'parent_form_fields' => $this->parent_form->fields,
            'user' => [
                'permission' => $user->getAllPermissions()->pluck('name'),
                'details' => $user->details()
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create', [
            'title' => "Create " . $this->modal_name_for_page_title,
        ]);
    }

    public function store(Request $request)
    {
        $user = $this->entity::create($this->form->setStoreOrUpdate($request));

        if (isset($request['password']) && $request['password'] != null) {
            $user->password = Hash::make($request->password);
            $user->update();
        }

        $user->syncRoles($request['roles']);

        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (isset($request['password']) && $request['password'] != null) {
            $user->password = Hash::make($request->password);
            $user->update();
        }

        $user->syncRoles($request['roles']);

        $this->form->setStoreOrUpdate($request, $this->entity::find($id))->update();
        return redirect('/' . $this->modal . '/' . $id);
    }
}
