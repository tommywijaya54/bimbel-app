<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PermissionController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Permission/Index', [
            'roles' => Role::all(),
            'permission' => Permission::all(),
            'users' => User::with('roles')->get()
        ]);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $role_permissions = $role->permissions();
        $users = $role->users();

        $permissions = Permission::all();

        return Inertia::render('Admin/Permission/Show', [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'users' => $users,
            'permissions' => $permissions,
        ]);
    }
}
