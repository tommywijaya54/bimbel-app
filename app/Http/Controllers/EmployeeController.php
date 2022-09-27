<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public $entity = Employee::class;
    public $modal = 'employee';

    // this used on INDEX VIEW
    public $list_view_fields = "id,nik,name,phone,email";
    public $list_view_action_button = 'create-employee';

    // this used on SHOW VIEW
    public $form_fields = 'nik,,name,address,phone,email,emergency_name,emergency_phone,join_date,exit_date,note,user,branch';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);

        // this used on index view for reducing the data variable
        $this->list_view_array = explode(",", $this->list_view_fields);





        // for Create View Fields & 
        $this->create_form_fields = 'nik,,name,address,phone,email,emergency_name,emergency_phone,join_date,exit_date,note,branch_id';  // str_replace(',user', '', $this->form_fields);

        // this used for Store function
        $this->store_form_fields = str_replace(",,", ',', $this->create_form_fields);


        // for Edit View Fields
        $this->clean_form_fields = str_replace(",,", ',', $this->form_fields);
        $this->edit_form_fields = $this->create_form_fields; // str_replace(',user', '', $this->clean_form_fields);
        $this->update_form_fields = str_replace(",,", ',', $this->create_form_fields);
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
            'form_fields' => $this->create_form_fields,
            'form_fields_options' => [
                'branch_id' => Branch::all(['id', 'name'])
            ],
            'modal' => $this->modal,
            'post_url' => "/" . $this->modal,
        ]);
    }

    public function store(Request $request)
    {
        $arr = [];
        $fieldnames = explode(",", $this->store_form_fields);

        foreach ($fieldnames as $a) {
            if ($request[$a]) {
                $arr[$a] = $request[$a];
            }
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => 'Employee',
            'password' => bcrypt('password'), // '$2y$10$5jVX3q8h6GnAqwN9KR9sVekmwYZQh0daV5.i65bzdXJMRYi/mtMZi', // password
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

        return Inertia::render('Simple/Edit', [
            'page_title' => 'Edit ' . $entity->name . ' ' . $this->modal,
            'component_header' => 'Edit Form ',
            'component_note' => 'To change name, email & password on your login information you need to contact administrator',

            'form_fields' =>  $this->edit_form_fields,
            'form_fields_options' => [
                'branch_id' => Branch::all(['id', 'name'])
            ],

            'data' => $entity,
            'post_url' => "/" . $this->modal . "/" . $entity->id,

            'modal' => $this->modal,
        ]);
    }

    public function update(Request $request, $id)
    {
        $fieldnames = explode(",", $this->update_form_fields);

        $entity = $this->entity::find($id);

        foreach ($fieldnames as $a) {
            if ($request[$a]) {
                $entity[$a] = $request[$a];
            }
        }

        $entity->update();

        return redirect('/' . $this->modal . '/' . $entity->id);
    }
}
