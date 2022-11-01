<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Inertia\Inertia;

class RegistrationController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,date,student_id,branch_id,status',
            'form' => 'date,,student_id,branch_id,reference,cashback,status,note'
        ], true);

        // $this->form->title_format = '{student.name}'
        $this->form->field('cashback')->inputtype = 'currency';
    }


    public function show($id)
    {
        $form_data = $this->form->displayForm($id);

        $renderData = [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            'items' => $form_data->entity_item->items
        ];

        return Inertia::render('Registration/Details', $renderData);
    }

    function add_item($id, $request)
    {
        $registration = Registration::find($id);
        $registration->entity_item()->create();
    }
}
