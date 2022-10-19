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
    public $entity;
    public $modal;

    function __construct($field_schema = null, $complete = false)
    {
        if (!$this->entity) {
            $model_url = 'App\\Models\\';
            $class_Url = get_class($this);                                                      //"App\Http\Controllers\PromolistController";
            $controller_name = substr($class_Url, strrpos($class_Url, '\\') + 1);               //$controller_name = str_replace('App\\Http\\Controllers\\', '', $class_Url);         // PromolistController
            $this->model_name = str_replace('Controller', '', $controller_name);                //Promolist
            $this->entity = $model_url . $this->model_name;
        }

        if (empty($complete)) {
            $this->tableInformation();
        }

        if (!$this->modal) {
            $this->modal = strtolower($this->model_name);                                   // modal is for url and display purpose so it's okay to edit it;
        }

        $this->modal_name_for_page_title = ucfirst($this->modal);

        $this->field_schema = $field_schema;

        if (isset($this->field_schema['list'])) {
            $this->list = new ListSchema($this->field_schema['list'], $this->modal, $this->entity);
        }

        if (isset($this->field_schema['form'])) {
            $this->form = new FormSchema($this->field_schema['form'], $this->modal, $this->entity);
        }
    }

    function index()
    {
        return Inertia::render('Common/List', [
            'title' =>  $this->modal_name_for_page_title . " List",
            'list' => $this->list->table_format(),
        ]);
    }
    public function create()
    {
        return Inertia::render('Common/CreateForm', [
            'title' => "Create " . $this->modal_name_for_page_title,
            'form_schema' => $this->form->createForm(),
        ]);
    }
    public function show($id)
    {
        $form_data = $this->form->displayForm($id);
        return Inertia::render('Common/DisplayForm', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
        ]);
    }
    public function edit($id)
    {
        $form_data = $this->form->editForm($id);
        return Inertia::render('Common/EditForm', [
            'title' => 'Edit ' . $form_data->title . ' ' . $this->modal_name_for_page_title,
            'form_schema' => $form_data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->form->validate['store']);

        $this->entity::create($this->form->setStoreOrUpdate($request));
        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->form->validate['update']);

        $this->form->setStoreOrUpdate($request, $this->entity::find($id))->update();
        return redirect('/' . $this->modal . '/' . $id);
    }

    private function tableInformation()
    {
        $this->table_name = with(new $this->entity)->getTable();
        $this->all_table_column = Schema::getColumnListing($this->table_name);
        $this->table_column = array_diff($this->all_table_column, ['id', 'created_at', 'created_by', 'updated_at']);

        echo "<pre>\n\n\n
        Add code below to your Controller:\n\n\n
        ";
        echo "\$this->init([
            'list' => 'id," . implode(",", $this->table_column) . "',
            'form' => '" . implode(",", $this->table_column) . "',
        ]);
        \n\n<hr>
        Add this code to your Model:\n";
        echo "
            protected \$fillable = [";
        foreach ($this->table_column as $column) {
            echo "\n\t\t\t'" . $column . "',";
        }
        echo "
    ];

            public function xxxx_id () {
                return \$this->belongsTo(xxxx::class);
            }
        ";
        echo " <//pre><hr><br/>Table Column:<br/>";
        print_r($this->table_column);
        die;
    }
}
