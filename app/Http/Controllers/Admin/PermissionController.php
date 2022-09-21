<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function show()
    {
    }
}
