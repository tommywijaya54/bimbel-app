<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{
    //

    public $entity = Branch::class;
    public $pagetitle = 'Branch';
    public $modal = 'branch';

    // public $mainUrl = ("/" . $this->modal);

    /*
    public $url = [
        'create' => $this->modal,
    ];
    */

    public $listViewColumn = "id,name,phone,address,email";
    public $listViewActionButton = 'create-branch';

    public $formInput = 'name,address,phone,email,open_date,status,manager_id';


    public function index()
    {
        $data = $this->entity::all();
        return Inertia::render('Simple/Index', [
            'pagetitle' => $this->pagetitle . " List",
            'data' => $data,
            'view' => $this->listViewColumn,
            'goto' => $this->modal,
            'action_button' => $this->listViewActionButton,
        ]);
    }

    public function create()
    {
        return Inertia::render('Simple/Create', [
            'pagetitle' => "Create " . $this->pagetitle,
            'postto' => "/" . $this->modal,
            'forminput' => $this->formInput,
        ]);
    }


    public function store(Request $request)
    {
        $this->entity::create([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'open_date' => $request['open_date'],
            'status' => $request['status'],
            'manager_id' => $request['manager_id'],
        ]);

        return redirect('/' . $this->modal);
    }

    public function show($id)
    {
        $entity = $this->entity::find($id);

        $entity->manager = $entity->manager();

        return Inertia::render('Simple/Show', [
            'pagetitle' => $entity->name . ' ' . $this->pagetitle,
            'component_header' => $this->pagetitle . ' Information',
            'data' => $entity,
            'view' => $this->formInput,
            'component_for' => $this->pagetitle,
        ]);
    }

    public function edit($id)
    {
        $entity = $this->entity::find($id);
        $entity->manager = $entity->manager();

        return Inertia::render('Simple/Show', [
            'pagetitle' => $entity->name . ' branch',
            'component_header' => 'Edit Form ',
            'data' => $entity,
            'postto' => "/" . $this->modal,
            'forminput' =>  $this->formInput,
        ]);
    }
}
