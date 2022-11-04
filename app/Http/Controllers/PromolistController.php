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
        parent::__construct([
            'list' => 'id:ID,label:Promotion Label,discount_value,branch_id,start_date,end_date',
            'form' => '
                branch_id,_,

                label:Promotion Label,

                discount_value,
                _,
                start_date,
                end_date',
        ], true);

        $this->form->title_format = '{label}';
    }
}
