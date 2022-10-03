<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends CommonController
{

    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,nik:NIK,name:Employee Name,phone,branch_id',
            'form' =>  'nik:NIK,,name,address,phone,email,emergency_name,emergency_phone,join_date,exit_date,note,branch_id'
        ], true);

        $this->form->title_format = "{nik} / {name}";
    }


    public function store(Request $request)
    {
        $employee = $this->entity::create($this->form->setStoreOrUpdate($request));

        $user = User::firstOrNew(['email' =>  $request('email')]);
        $user->name = request('name');
        $user->type = 'Student';
        $user->password = bcrypt('password');
        $user->save();

        $employee->user_id = $user->id;
        $employee->update();

        return redirect('/' . $this->modal);
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
}
