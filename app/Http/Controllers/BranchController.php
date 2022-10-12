<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchExpense;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name,phone,address,email, manager_id',
            'form' => 'name:Branch Name,manager_id,address,phone,email,open_date,status',
        ], true);

        $this->list->order_by = 'ASC';
        $this->list->item_url = '/branch/{id}/details';

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
            'form_schema' => $this->form->displayForm($id),
            // 'branch' => compact('branch'),
            // 'assets' => $assets
        ]);
    }

    public function add_expense($id, Request $request)
    {
        $branch = Branch::find($id);
        $branch->expenses()->create([
            'date' => $request->date,
            'expense_type' => $request->expense_type,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);
    }

    public function delete_expense($id, $item_id)
    {
        $branch = Branch::find($id);
        $item = $branch->expenses()->find($item_id);
        $item->delete();
    }


    public function add_rental($id, Request $request)
    {
        $branch = Branch::find($id);
        $branch->rentals()->create([
            'date' => $request->date,
            'expense_type' => $request->expense_type,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);
    }

    public function add_asset($id, Request $request)
    {
        $branch = Branch::find($id);
        $branch->assets()->create([
            'date' => $request->date,
            'expense_type' => $request->expense_type,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);
    }
}
