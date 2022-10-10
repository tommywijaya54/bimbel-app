<?php

namespace App\Http\Controllers;

class PricelistController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id:ID, start_date, end_date, branch_id, level,price,school_type,subject,week',
            'form' => 'branch_id,level,price,school_type,week,subject,start_date,end_date,',
        ], true);

        $this->form->title_format = "{subject}";
        $this->form->field('level')->hasOptions(['TKA', 'TKB', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12']);
        $this->form->field('school_type')->hasOptions(['International', 'National', 'International & National']);
    }
}
