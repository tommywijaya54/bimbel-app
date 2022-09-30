<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use App\Models;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CommonController extends Controller
{
    public $model_name = "tom";

    function __construct()
    {
        $this->model_name = str_replace('Controller', '', get_class($this));
        $this->entity = 'App\\Models\\' . $this->model_name;
        $this->modal = strtolower($this->model_name);

        // $this->entity = ('App\\Models\\' . $this->model_name)::class;

        $this->table_name = with(new $this->entity)->getTable();
        $this->all_table_column = Schema::getColumnListing($this->table_name);
        $this->list = new ListSchema('id', $this->modal, $this->entity);

        //$this->list->include(['student', 'branch']);
        /*
        $this->form_schema = new FormSchema('date,,student_id,branch_id,reference,cashback::number,status,note', $this->modal);
        $this->form_schema->field('student_id')->hasOptions(Student::all(['id', 'name'])->toArray(), 'datalist');
        $this->form_schema->field('branch_id')->hasOptions(Branch::all(['id', 'name'])->toArray(), 'datalist');
        */
    }

    function index()
    {
        //dd($this->entity::all());
        print_r($this);

        return Inertia::render('Common/List', [
            'title' =>   " List",
            'list' => $this->list->table_format(),
        ]);
    }

    public function show($id)
    {
        $entity = $this->entity::find($id)->toArray();
        return Inertia::render('Common/DisplayForm', [
            'title' => $entity['id'] . ' ' . $this->model_name . ' ',
            'form_schema' => $this->form_schema->withValue($entity)->displayForm(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Common/CreateForm', [
            'title' => "Create " . $this->model_name,
            'form_schema' => $this->form_schema->createForm(),
        ]);
    }

    public function edit($id)
    {
        $entity = $this->entity::find($id);
        $form_schema = $this->form_schema->withValue($entity)->editForm();
        return Inertia::render('Common/EditForm', [
            'title' => 'Edit ' . $entity['id'] . ' ' . $this->modal,
            'form_schema' => $form_schema,
        ]);
    }

    public function store(Request $request)
    {
        $this->entity::create($this->form_schema->setStoreOrUpdate($request));
        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $this->form_schema->setStoreOrUpdate($request, $this->entity::find($id))->update();
        return redirect('/' . $this->modal . '/' . $id);
    }
}
