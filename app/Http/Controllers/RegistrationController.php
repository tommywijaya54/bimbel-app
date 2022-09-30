<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FormSchema;
use App\ListSchema;
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

        $this->list = new ListSchema('id,date,student,branch,status', $this->modal, $this->entity);
        $this->list->include(['student', 'branch']);

        $this->form_schema = new FormSchema('date,,student_id,branch_id,reference,cashback::number,status,note', $this->modal);
        $this->form_schema->field('student_id')->hasOptions(Student::all(['id', 'name'])->toArray(), 'datalist');
        $this->form_schema->field('branch_id')->hasOptions(Branch::all(['id', 'name'])->toArray(), 'datalist');

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
        // with('student', 'branch')
        //$data = $this->entity::all($this->list_view_array)->with('student');

        // $data = $this->entity::with('student', 'branch')->get();
        return Inertia::render('Common/List', [
            'title' => $this->model_name . " List",
            'list' => $this->list->table_format(),
            /*
            'fields' => $this->list_view_fields,
            'data' => $data,

            'item_url' => "/" . $this->modal . "/{id}",
            'modal' => $this->modal,
            */
        ]);
    }
    public function show($id)
    {
        $entity = $this->entity::with('student', 'branch')->find($id)->toArray();

        // print_r($entity);
        // $this->form_schema = $this->form_schema->addField('student');
        // $this->form_schema->addField('student');
        // $this->form_schema->addField('branch');

        return Inertia::render('Common/DisplayForm', [
            'title' => $entity['id'] . ' ' . $this->model_name . ' ',
            'entity' => $entity,
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
