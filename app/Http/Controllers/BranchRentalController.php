<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\Models\Branch;
use App\Models\BranchRental;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchRentalController extends CommonController
{
    //
    public $modal = 'Branch Rental';

    function __construct()
    {
        parent::__construct([
            'form' => 'branch_id,_,start_date,end_date,amount,_,owner_name,owner_phone,notaris_name,notaris_phone,note'
        ], true);

        // $this->form = new FormSchema($this->field_schema['form'], $this->modal, $this->entity);
    }

    public function create_rental($branch_id)
    {
        $branch = Branch::find($branch_id);
        $form = $this->form->createForm();
        $form->field('branch_id')->value = $branch->id . ' : ' . $branch->name;
        $form->submit_url = '/branch/' . $branch_id . '/rental';

        return Inertia::render('Common/CreateForm', [
            'title' => "Create Rental for " . $branch->name,
            'form_schema' => $form,
        ]);
    }

    public function store_rental($branch_id, Request $request)
    {
        $branch = Branch::find($branch_id);
        $branch->rentals()->create($this->form->setStoreOrUpdate($request));

        return redirect('/branch/' . $branch_id . '/details');
    }


    public function show_rental($branch_id, $rental_id)
    {
        $branch = Branch::find($branch_id);
        $rental = BranchRental::find($rental_id);

        $form_data = $this->form->displayForm($rental_id);


        $form_data->title = 'Rental dengan ' . $rental->owner_name;
        $form_data->urls = [
            [
                'link' => $rental_id . '/edit',
                'label' => 'Edit Rental'
            ]
        ];

        return Inertia::render('Common/DisplayForm', [
            'title' => 'Branch ' . $branch_id . ' : ' . $branch->name . ' rental information',
            'form_schema' => $form_data,
        ]);
    }

    public function edit_rental($branch_id, $rental_id)
    {
        $branch = Branch::find($branch_id);

        $form_data = $this->form->editForm($rental_id);
        $form_data->submit_url = '/branch/' . $branch_id . '/rental/' . $rental_id;

        return Inertia::render('Common/EditForm', [
            'title' => 'Edit ' . $form_data->title . ' ' . $this->modal_name_for_page_title,
            'form_schema' => $form_data,
        ]);
    }

    public function update_rental(Request $request, $branch_id, $rental_id)
    {
        $branch = Branch::find($branch_id);

        $this->form->setStoreOrUpdate($request, $this->entity::find($rental_id))->update();

        return redirect('/branch/' . $branch_id . '/details');
    }
}
