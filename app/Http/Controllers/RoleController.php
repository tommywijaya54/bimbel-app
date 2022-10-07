<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends CommonController
{
    public $entity = Role::class;
    public $modal = 'role';

    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name:Role Name,user',
            // 'form' => 'name:Role Name,--,users:-label=People that have this role-extrafield=true,--,permissions'
            'form' => 'name:Role Name,,permissions'
        ], true);
        $this->list->order_by = 'ASC';
        $this->form->title_format = '{name}';
        /*
        $this->list->field('users')->getValue = function ($field, $id) {
            return Role::findById($id)->users->toArray();
        };
        */

        $permissions_field = $this->form->field('permissions');
        $permissions_field->hasOptions(
            Permission::pluck('name')->toArray(),
            'multiple-checkbox'
        );

        $permissions_field->special_request = 'group-the-options';
        $permissions_field->getValue = function ($field, $id) {
            $role = Role::find($id);
            $value = $role->permissions()->pluck('name')->toArray();
            return $value;
        };
    }

    public function create()
    {
        return Inertia::render('Common/CreateForm', [
            'title' => "Create " . $this->modal_name_for_page_title,
            'form_schema' => $this->form->createForm(),
        ]);
    }

    public function show($id)
    {
        $form_data = $this->form->displayForm($id);

        $role = $this->entity::find($id);
        $users = User::role($role->name)->get()->toArray();

        $role_permissions = $role->permissions()->pluck('name')->toArray();
        $available_permissions = Permission::pluck('name')->toArray();

        return Inertia::render('Role/Show', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            'users' => $users,
            'role_permissions' => $role_permissions,
            'available_permissions' => $available_permissions,
        ]);
    }

    public function edit($id)
    {
        $form_data = $this->form->editForm($id);
        return Inertia::render('Role/EditForm', [
            'title' => 'Edit ' . $form_data->title . ' ' . $this->modal_name_for_page_title,
            'form_schema' => $form_data
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findById($id);
        $role->name = $request['name'];
        $role->update();

        $role->syncPermissions($request['permissions']);
        return redirect('/' . $this->modal . '/' . $id);
    }
}
