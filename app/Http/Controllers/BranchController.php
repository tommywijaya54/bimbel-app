<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class BranchController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name,phone,address,email, manager_id',
            'form' => 'manager_id,name:Branch Name,address,phone,email,open_date,status',
        ], true);
        $this->list->order_by = 'ASC';

        $this->form->title_format = "{name}";
        $this->form->field('manager_id')->hasOptions(
            User::role('Branch Manager')->get()->toArray(),
            'datalist'
        );
    }

    public function details($id)
    {
        $branch = $this->entity::with('assets', 'rentals', 'expenses', 'manager')->find($id);
        // $assets = $branch->assets;
        // dd($branch->assets());

        return Inertia::render('Branch/Details', [
            'title' => 'Branch Details',
            'branch' => $branch,
            // 'branch' => compact('branch'),
            // 'assets' => $assets
        ]);
    }
}
