<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\Models\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,name:School Name,city,address',
            'form' => 'name:School Name,address,city,type,color_code'
        ], true);

        $this->list->order_by = 'ASC';

        $this->form->title_format = '{name}';
        $this->form->field('type')->hasOptions(['International', 'National', 'International & National']);
        $this->form->field('color_code')->inputtype = 'color';
    }
}
