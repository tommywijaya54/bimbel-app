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

        // $this->rental_form =
    }

    public function details($id)
    {
        $branch = $this->entity::with('assets', 'rentals', 'expenses', 'manager')->find($id);
        // $assets = $branch->assets;
        // dd($branch->assets());

        return Inertia::render('Branch/Details', [
            'title' => 'Branch Details',
            'branch' => $branch,
            // 'form_schema' => $this->form->displayForm($id),
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

    public function add_rental($id, Request $request)
    {
        $branch = Branch::find($id);
        $branch->rentals()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'amount' => $request->amount,
            'owner_name' => $request->owner_name,
            'owner_phone' => $request->owner_phone,
            'notaris_name' => $request->notaris_name,
            'notaris_phone' => $request->notaris_phone,
            'note' => $request->note,
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
