<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class RoleController extends CommonController
{
    public $entity = Role::class;
    public $modal = 'role';

    function __construct()
    {
        parent::__construct([
            'list' => 'id,name',
            'form' => 'name'
        ], true);
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

        $role_permission = $role->permissions()->get()->toArray();
        $users = User::role($role->name)->get()->toArray();

        return Inertia::render('Role/Show', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            'role_permission' => $role_permission,
            'users' => $users,
        ]);
    }
    public function edit($id)
    {
        $form_data = $this->form->editForm($id);

        $role = $this->entity::find($id);

        $role_permission = $role->permissions()->get()->toArray();
        $available_permissions = Permission::select('id', 'name')->get()->toArray();

        return Inertia::render('Common/EditForm', [
            'title' => 'Edit ' . $form_data->title . ' ' . $this->modal_name_for_page_title,
            'form_schema' => $form_data,
        ]);
    }
}
