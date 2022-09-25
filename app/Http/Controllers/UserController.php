<?php

namespace App\Http\Controllers;

use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return Inertia::render('Simple/Index', [
            'pagetitle' => "User List",
            'data' => $data,
            'goto' => 'user',
            'view' => "id,name,email,type"
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $details = $user->details();
        return Inertia::render('User/Show', [
            'user' => $user,
            'details' => $details
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
        ]);
    }


    public function edit($id)
    {
        $data = User::find($id);
        return Inertia::render('User/Edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $entity = User::find($id);
        $entity->name = $request->name;
        $entity->email = $request->email;
        $entity->password = $request->password;

        $entity->update();
        return Redirect::route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::back()->with('message', 'User deleted.');
    }
}
