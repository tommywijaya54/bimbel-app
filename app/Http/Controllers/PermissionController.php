<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class PermissionController extends Controller
{

    public function index()
    {
        return Inertia::render('Permission/Index', [
            'roles' => Role::orderBy('id', 'asc')->get(['name', 'id']),
            'permission' => Permission::all(['id', 'name']),
            'users' => User::with('roles')->get(['id', 'name'])
        ]);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $role_permissions = $role->permissions();
        $users = $role->users(); //->get(['id', 'name']); //->select('id', 'name')->get();

        $permissions = Permission::select('id', 'name')->get();

        return Inertia::render('Permission/Show', [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'users' => $users,
            'permissions' => $permissions,
        ]);
    }
}
