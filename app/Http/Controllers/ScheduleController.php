<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use App\Models\Schedule;
use App\Models\ScheduleItem;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends CommonController
{
    //
    public function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,class_subject,class_room,teacher_id',
            'form' => 'class_subject,class_room,branch_id,teacher_id:Teacher Name,students:Student Names,week|nr'
        ], true);

        $this->list->item_url = 'schedule/{id}/details';
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

        $this->form->item_form = new FormSchema('day:Hari|ex,session_date:Tanggal,session_start_at:Mulai jam,session_end_at:Selesai jam', 'Schedule Item', ScheduleItem::class);
        $this->form->item_form->getField(
            ['day'],
            function ($field) {
                $field->inputtype = 'none';
                $field->required = false;
                $field->attr = [
                    'style' => ['display' =>  'none']
                ];
            }
        );
        $this->form->item_form->getField(
            ['session_start_at', 'session_end_at'],
            function ($field) {
                $field->inputtype = 'time';
                $field->attr = [
                    'style' => ['width' =>  '140px']
                ];
            }
        );
    }

    public function details($id)
    {
        $schedule = $this->entity::with('items')->find($id);
        $form = $this->form->displayForm($id);

        return Inertia::render('Schedule/Details', [
            'title' => 'Schedule Details',
            'form_schema' => $form,
            'schedule' => $schedule,
        ]);
    }

    public function add_item($id, Request $request)
    {
        $schedule = Schedule::find($id);
        //dd($request['session_date']);

        $schedule->items()->create([
            'session_date' => $request['session_date'],
            'session_start_at' => $request->session_start_at,
            'session_end_at' => $request->session_end_at
        ]);
    }

    public function delete_item($id, $item_id)
    {
        $schedule = Schedule::find($id);
        $item = $schedule->items()->find($item_id);
        $item->delete();
    }
}
