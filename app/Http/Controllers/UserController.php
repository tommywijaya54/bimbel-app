<?php

namespace App\Http\Controllers;

use App\Models\Branch;
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
            'list' => 'id,name,email,type',
            'form' => 'name,email,type,status,password:-extrafield=true,disabled:Deactivation Reason,roles:-extrafield=true'
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
    }


    public function show($id)
    {
        $form_data = $this->form->displayForm($id);
        $user = $this->entity::find($id);
        // $user = ->details()

        return Inertia::render('User/Show', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            'user' => [
                'permission' => $user->getAllPermissions()->pluck('name'),
                'details' => $user->details()
            ]
        ]);
    }


    public function store(Request $request)
    {
        $user = $this->entity::create($this->form->setStoreOrUpdate($request));

        if (isset($request['password'])) {
            $user->password = Hash::make($request->password);
            $user->update();
        }

        $user->syncRoles($request['roles']);

        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (isset($request['password'])) {
            $user->password = Hash::make($request->password);
            $user->update();
        }

        $user->syncRoles($request['roles']);

        $this->form->setStoreOrUpdate($request, $this->entity::find($id))->update();
        return redirect('/' . $this->modal . '/' . $id);
    }
}
