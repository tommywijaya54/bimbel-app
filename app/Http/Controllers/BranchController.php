<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{

    public $entity = Branch::class;
    public $modal = 'branch';

    public $list_view_fields = "id,name,phone,address,email";
    public $list_view_action_button = 'create-branch';

    public $form_fields = 'name,address,phone,email,open_date,status,manager_id';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);
    }

    public function index()
    {
        $data = $this->entity::all();
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
            'form_fields' => $this->form_fields,
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

        $this->entity::create($arr);
        return redirect('/' . $this->modal);
    }

    public function show($id)
    {
        $entity = $this->entity::find($id);
        $entity->manager = $entity->manager();

        return Inertia::render('Simple/Show', [
            'page_title' => $entity->name . ' ' . $this->model_name . ' ',
            'component_header' => $this->model_name . ' Information',

            'form_fields' => $this->form_fields,
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
