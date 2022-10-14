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
            'form' => 'name:Branch Name,manager_id,address,phone,email,open_date,status',
        ], true);

        $this->list->order_by = 'ASC';
        $this->list->item_url = '/branch/{id}/details';

        $this->form->title_format = "{name}";
        $this->form->field('manager_id')->hasOptions(
            User::role('Branch Manager')->get()->toArray(),
            'datalist'
        );

        // $this->rental_form = new FormSchema('branch_id,_,start_date,end_date,amount,_,owner_name,owner_phone,notaris_name,notaris_phone,note', 'Branch Rental', BranchRental::class);

        // $this->rental_form =
    }

    public function details($id)
    {
        $branch = $this->entity::with('assets', 'rentals', 'expenses', 'manager')->find($id);
        // $assets = $branch->assets;
        // dd($branch->assets());
        /*
        $table->integer('branch_id');
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('amount');
        $table->string('owner_name');
        $table->string('owner_phone');
        $table->string('notaris_name')->nullable();
        $table->string('notaris_phone')->nullable();
        $table->string('note')->nullable(); */


        return Inertia::render('Branch/Details', [
            'title' => 'Branch Details',
            'branch' => $branch,

            // 'rental_form' => $RentalForm->createForm(),
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
    /*
    public function create_rental($id)
    {

        $branch = Branch::find($id);
        $this->rental_form->field('branch_id')->value = $id . ' : ' . $branch->name;

        $form = $this->rental_form->createForm();
        $form->submit_url = '/branch/' . $id . '/rental';


        return Inertia::render('Common/CreateForm', [
            'title' => "Create new rental record for " . $branch->name,
            'form_schema' => $form,
        ]);
    }

    public function show_rental($id, $rental_id)
    {
        $form_data = $this->rental_form->displayForm($rental_id);
        return Inertia::render('Common/DisplayForm', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
        ]);
    }

    public function add_rental($id, Request $request)
    {
        $request->validate([
            'branch_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'amount' => 'required',
            'owner_name' => 'required',
            'owner_phone' => 'required',
            'notaris_name' => 'required',
            'notaris_phone' => 'required'
        ]);
        $branch = Branch::find($id);
        $branch->rentals()->create(
            $this->rental_form->setStoreOrUpdate($request)
        );
    }
    */

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
