<?php

namespace App\Http\Controllers;

use App\Models\User;

class BranchController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id,name,phone,address,email, manager_id',
            'form' => 'manager_id,name:Branch Name,address,phone,email,open_date,status',
        ], true);
        $this->list->order_by = 'ASC';

        $this->form->title_format = "{name}";
        $this->form->field('manager_id')->hasOptions(
            User::role('Branch Manager')->get()->toArray(),
            'datalist'
        );
    }
}
