<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class PermissionController extends Controller
{

    public $entity = Role::class;
    public $modal = 'role';

    function __construct()
    {
        $this->model_name = ucfirst($this->modal);

        $this->list = new ListSchema('id,name,users', $this->modal, $this->entity);
        $this->list->include(['users']);

        $this->form_schema = new FormSchema('date,,student_id,branch_id,reference,cashback::number,status,note', $this->modal);
        //$this->form_schema->field('student_id')->hasOptions(Student::all(['id', 'name'])->toArray(), 'datalist');
        //$this->form_schema->field('branch_id')->hasOptions(Branch::all(['id', 'name'])->toArray(), 'datalist');

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
        return Inertia::render('Common/List', [
            'title' => $this->model_name . " List",
            'list' => $this->list->table_format(),
        ]);
        /*
        return Inertia::render('Permission/Index', [
            'roles' => Role::orderBy('id', 'asc')->get(['name', 'id']),
            'permission' => Permission::all(['id', 'name']),
            'users' => User::with('roles')->get(['id', 'name'])
        ]);
        */
    }

    public function show($id)
    {
        $role = Role::find($id);
        $role_permissions = $role->permissions();
        $users = $role->users(); //->get(['id', 'name']); //->select('id', 'name')->get();

        $permissions = Permission::select('id', 'name')->get();

        return Inertia::render('Permission/Show', [
            'role' => $role,
            'role_permissions' => $role_permissions,
            'users' => $users,
            'permissions' => $permissions,
        ]);
    }
}
