<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PromolistController extends CommonController
{
    function __construct()
    {
        $this->init([
            'list' => 'id,label,branch_id,start_date,end_date,discount_value',
            'form' => 'label,branch_id,start_date,end_date,discount_value',
        ], true);

        $this->form->title_format = '{label}';
    }
}
