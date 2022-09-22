<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    //

    public function index()
    {
        //$data = User::all()
        /* 
        $data = (User::with('roles')->get())->map(function ($user) {
            $user->roleText = $user->roles->map(function ($aRole) {
                return $aRole->name;
            });

            $user->role = "Tommy";

            return $user;
        });
        */

        $data = (User::with('roles')->get());
        return Inertia::render('Admin/User/Index', [
            'pagetitle' => "Admin User List",
            'data' => $data,
            // 'route' => 'user.show',
            // 'view' => "name,email,role"
        ]);
    }
}
