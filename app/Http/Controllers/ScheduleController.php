<?php

namespace App\Http\Controllers;

use App\ListSchema;
use App\Models\ScheduleItem;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends CommonController
{
    //
    public function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,class_subject,class_room,teacher_id',
            'form' => 'class_subject,class_room,teacher_id:Teacher Name,students:Student Names,week|nr'
        ], true);

        $this->form->title_format = '{class_subject} / {class_room}';

        $teacher_field = $this->form->field('teacher_id');
        $teacher_field->hasOptions(
            User::role('Teacher')->get()->toArray(),
            'datalist'
        );

        $teacher_field->route['show'] = 'user.show';

        $students_field = $this->form->field('students');
        $students_field->hasOptions(
            User::role('Student')->get(['id', 'name'])->toArray(),
            'datalist-multiple-value'
        );

        $items = [];
        $items['list'] = new ListSchema('start_at,end_at', 'Schedule Item', ScheduleItem::class);
        $items['list']->order_by = 'ASC';

        $this->form->subform = [$items];
    }
}
