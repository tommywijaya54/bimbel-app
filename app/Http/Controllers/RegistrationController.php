<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FormSchema;
use App\Models\Branch;
use App\Models\Registration;
use App\Models\School;
use App\Models\Student;
use Inertia\Inertia;
use PHPUnit\Framework\MockObject\Builder\Stub;

class RegistrationController extends Controller
{
    public $entity = Registration::class;
    public $modal = 'registration';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);

        $this->list_view_fields = 'id,date,student_id,branch_id,status';
        $this->list_view_array = explode(",", $this->list_view_fields);

        $this->form_schema = new FormSchema('date,,student_id,branch_id,reference,cashback::number,status,note', $this->modal);
        $this->form_schema->field('student_id')->hasOptions(Student::all(['id', 'name']));
        $this->form_schema->field('branch_id')->hasOptions(Branch::all(['id', 'name']));

        /*
        $table->integer('student_id');
        $table->integer('branch_id');
        $table->date('date');
        $table->string('reference');
        $table->integer('cashback');
        $table->string('status')->nullable();
        $table->string('note')->nullable();
        */
    }

    public function index()
    {
        $data = $this->entity::all($this->list_view_array);
        return Inertia::render('Simple/Index', [
            'page_title' => $this->model_name . " List",
            'fields' => $this->list_view_fields,
            'data' => $data,
            'item_url' => "/" . $this->modal . "/{id}",
            'modal' => $this->modal,
        ]);
    }
    public function show($id)
    {
        $entity = $this->entity::find($id);
        return Inertia::render('Common/DisplayForm', [
            'title' => $entity->name . ' ' . $this->model_name . ' ',
            'form_schema' => $this->form_schema->withValue($entity)->displayForm(),
        ]);
    }
    public function create()
    {
        $this->form_schema->createForm();
        return Inertia::render('Common/CreateForm', [
            'title' => "Create " . $this->model_name,
            'form_schema' => $this->form_schema,
        ]);
    }
    public function edit($id)
    {
        $entity = $this->entity::find($id);
        $form_schema = $this->form_schema->withValue($entity)->editForm();

        // $form_schema->form_note = "To Edit you need admin access";

        return Inertia::render('Common/EditForm', [
            'title' => 'Edit ' . $entity->name . ' ' . $this->modal,
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
