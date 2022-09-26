<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PermissionController extends Controller
{

    public function index()
    {
        return Inertia::render('Permission/Index', [
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

        return Inertia::render('Permission/Show', [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'users' => $users,
            'permissions' => $permissions,
        ]);
    }
}
