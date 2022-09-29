<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class SchoolController extends Controller
{
    public $entity = School::class;
    public $modal = 'school';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);
        $this->list_view_action_button = 'create-' . $this->modal;

        // this used on Index/List view for reducing the data variable
        $this->list_view_fields = 'id,name,address';
        $this->list_view_array = explode(",", $this->list_view_fields);

        $this->show_form_fields = 'name,address,city,type,color_code';

        // for Create View Fields &
        $this->create_form_fields = 'name,address,city,type,color_code';
        $this->form_fields_options = [];

        // this used for Store function
        $this->store_form_fields = str_replace(",,", ',', $this->create_form_fields);

        // for Edit View Fields
        $this->edit_form_fields = $this->create_form_fields;
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
            'form_fields_options' => $this->form_fields_options,
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
        $this->entity::create($arr);
        return redirect('/' . $this->modal);
    }

    public function show($id)
    {
        $entity = $this->entity::find($id);
        return Inertia::render('Simple/Show', [
            'page_title' => $entity->name . ' ' . $this->model_name . ' ',
            'component_header' => $this->model_name . ' Information',

            'form_fields' => $this->show_form_fields,
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
            'form_fields_options' => $this->form_fields_options,

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
