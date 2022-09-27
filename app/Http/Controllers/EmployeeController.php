<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public $entity = Employee::class;
    public $modal = 'employee';

    public $list_view_fields = "id,nik,name,phone,email";
    public $list_view_action_button = 'create-employee';

    public $form_fields = 'nik,,name,address,phone,email,emergency_name,emergency_phone,join_date,exit_date,note,user,branch';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);
        $this->list_view_array = explode(",", $this->list_view_fields);
    }

    public function index()
    {
        $data = $this->entity::all($this->list_view_array);
        return Inertia::render('Simple/Index', [
            'page_title' => $this->model_name . " List",
            'action_button' => $this->list_view_action_button,
            'fields' => $this->list_view_fields,
            'data' => $data,
            'item_url' => "/" . $this->modal . "/{id}",
            'modal' => $this->modal,
        ]);
    }

    public function create()
    {
        return Inertia::render('Simple/Create', [
            'page_title' => "Create " . $this->model_name,
            'form_fields' => str_replace(',user_id', '', $this->form_fields),
            'modal' => $this->modal,
            'post_url' => "/" . $this->modal,
        ]);
    }

    public function store(Request $request)
    {
        $arr = [];
        $fieldnames = explode(",", $this->form_fields);

        foreach ($fieldnames as $a) {
            $arr[$a] = $request[$a];
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => 'Employee',
            'password' => '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi', // password
        ]);

        $employee = $this->entity::create($arr);

        $employee->user_id = $user->id;
        $employee->update();

        return redirect('/' . $this->modal);
    }

    public function show($id)
    {
        $entity = $this->entity::with('user', 'branch')->find($id);
        $entity->role = $entity->user->roles->pluck('name');

        // get branch
        // get user account 
        // get role

        return Inertia::render('Simple/Show', [
            'page_title' => $entity->name . ' ' . $this->model_name . ' ',
            'component_header' => $this->model_name . ' Information',

            'form_fields' => $this->form_fields . ',role',
            'data' => $entity,

            'modal' => $this->modal,
        ]);
    }

    public function edit($id)
    {
        $entity = $this->entity::find($id);
        $entity->manager = $entity->manager();

        return Inertia::render('Simple/Edit', [
            'page_title' => 'Edit ' . $entity->name . ' branch',
            'component_header' => 'Edit Form ',

            'form_fields' =>  $this->form_fields,
            'data' => $entity,
            'post_url' => "/" . $this->modal . "/" . $entity->id,

            'modal' => $this->modal,
        ]);
    }

    public function update(Request $request, $id)
    {
        $fieldnames = explode(",", $this->form_fields);
        $entity = $this->entity::find($id);

        foreach ($fieldnames as $a) {
            $entity[$a] = $request[$a];
        }

        $entity->update();
        return redirect('/' . $this->modal . '/' . $entity->id);
    }
}
