<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\Models\Branch;
use App\Models\BranchExpense;
use App\Models\BranchRental;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name,phone,address,email, manager_id',
            'form' => 'name:Branch Name,manager_id,address,phone,email|nr,_,open_date|nr,status|nr',
        ], true);

        $this->list->order_by = 'ASC';
        $this->list->item_url = '/branch/{id}/details';

        $this->form->title_format = "{name}";

        $manager_field = $this->form->field('manager_id');
        $manager_field->hasOptions(
            User::role('Branch Manager')->get()->toArray(),
            'datalist'
        );

        $this->form->field('name')->attr['placeholder'] = 'Fill Branch Name';
        $this->form->field('manager_id')->route['show'] = 'user.show';
    }

    public function details($id)
    {
        $branch = $this->entity::with('assets', 'rentals', 'expenses', 'manager')->find($id);

        return Inertia::render('Branch/Details', [
            'title' => 'Branch Details',
            'branch' => $branch,
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

    public function add_asset($id, Request $request)
    {
        $branch = Branch::find($id);
        $branch->assets()->create([
            'purchase_date' => $request->purchase_date,
            'item_name' => $request->item_name,
            'qty' => $request->qty,
            'cost' => $request->cost,
            'note' => $request->note
        ]);
    }

    public function delete_expense($id, $item_id)
    {
        $branch = Branch::find($id);
        $item = $branch->expenses()->find($item_id);
        $item->delete();
    }

    public function delete_asset($id, $item_id)
    {
        $branch = Branch::find($id);
        $item = $branch->assets()->find($item_id);
        $item->delete();
    }

    public function delete_rental($id, $item_id)
    {
        $branch = Branch::find($id);
        $item = $branch->rentals()->find($item_id);
        $item->delete();
    }
}
