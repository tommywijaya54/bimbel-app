<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public $entity = User::class;
    public $modal = 'user';

    public $list_view_fields = "id,name,email,type";

    public $form_fields = 'name,email,type,status,password';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);
    }

    public function index()
    {
        $data = $this->entity::all();
        return Inertia::render('Simple/Index', [
            'page_title' => $this->model_name . " List",
            'fields' => $this->list_view_fields,
            'data' => $data,
            'item_url' => "/" . $this->modal . "/{id}",

        ]);
    }

    public function show($id)
    {
        $user = $this->entity::find($id);
        $details = $user->details();


        return Inertia::render('User/Show', [
            'user' => $user,
            'details' => $details,
            'branch' => Branch::select('id', 'name')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Simple/Create', [
            'page_title' => "Create " . $this->model_name,
            'postto' => "/" . $this->modal,
            'forminput' => $this->formInput,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request, $request['type'], $request['status']);

        $this->entity::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'type' => $request['type'],
            'status' => $request['status'],
        ]);
        return redirect('/' . $this->modal);
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
