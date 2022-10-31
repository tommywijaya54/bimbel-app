<?php

namespace App\Http\Controllers;

use App\FormSchema;
use App\ListSchema;
use App\Models\Schedule;
use App\Models\ScheduleItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class ScheduleController extends CommonController
{
    public function __construct()
    {
        parent::__construct([
            'list' => 'id:ID,class_subject,class_room,teacher_id',
            'form' => 'teacher_id:Teacher Name,class_subject,branch_id,class_room,students_id:Student Names|ex'
        ], true);

        $this->form->title_format = '{class_subject} / {class_room}';
        array_push($this->form->with_list, 'items');

        $teacher_field = $this->form->field('teacher_id');
        $teacher_field->hasOptions(
            User::role('Teacher')->get()->toArray(),
            'datalist'
        );
        $teacher_field->route['show'] = 'user.show';

        $students_field = $this->form->field('students_id');
        $students_field->getValue = function ($field, $id, $data) {
            return collect($data['students'])->map(function ($item) {
                return $item['student_id'];
            })->toArray();
        };
        $students_field->hasOptions(
            User::role('Student')->get(['id', 'name'])->toArray(),
            'datalist-multiple-value'
        );
    }

    public function create()
    {
        $form = $this->form->createForm();
        return Inertia::render('Schedule/Details', [
            'title' => 'Schedule Details',
            'form_schema' => $form,
            'schedule' => $form->data,
        ]);
    }

    public function show($id)
    {
        $form = $this->form->editForm($id);
        return Inertia::render('Schedule/Details', [
            'title' => 'Schedule Details',
            'form_schema' => $form,
            'schedule' => $form->data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "teacher_id" => "required",
            "class_subject" => "required",
            "branch_id" => "required",
            "class_room" => "required",
            "students_id" => "required",
            "items" => "required",
        ]);

        $schedule = Schedule::create([
            "teacher_id" => $request->teacher_id,
            "class_subject" => $request->class_subject,
            "branch_id" => $request->branch_id,
            "class_room" => $request->class_room
        ]);

        $students = collect($request->students_id)->map(function ($item) {
            return ['student_id' => $item];
        })->toArray();
        $schedule->students()->createMany($students);
        $schedule->items()->createMany($request->items);

        return redirect('/' . $this->modal . '/' . $schedule->id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "teacher_id" => "required",
            "class_subject" => "required",
            "branch_id" => "required",
            "class_room" => "required",
            "students_id" => "required",
            "items" => "required",
        ]);

        $schedule = Schedule::with(['students', 'items'])->find($id);
        $schedule->update([
            "teacher_id" => $request->teacher_id,
            "class_subject" => $request->class_subject,
            "branch_id" => $request->branch_id,
            "class_room" => $request->class_room
        ]);

        // 

        // Update Student (Delete & Create)
        $students_id = $schedule->students->pluck('student_id');
        $delete_students = $students_id->diff($request->students_id);
        $schedule->students->filter(function ($item) use ($delete_students) {
            return $delete_students->first(function ($itemid, $key) use ($item) {
                return $itemid == $item->student_id;
            });
        })->each(function ($item) {
            $item->forceDelete();
        });
        $schedule->students()->createMany((collect($request->students_id)->diff($students_id))->map(function ($item) {
            return ['student_id' => $item];
        }));

        // Update Items (Delete)
        $items_dates = $schedule->items->pluck('session_date');
        dd($request->items);

        $request_items = collect($request->items);
        $delete_items = '';
        $new_items = '';

        echo '<pre>';

        if ($items_dates[0] == $request_items[0]) {
            echo '\n= = = same date = = =\n';
        } else {
            echo "\n not same \n";
        }

        echo '<strong>items_dates</strong><br>';
        print_r($items_dates);


        echo '<strong>request_items</strong><br>';
        print_r($request_items);

        echo '</pre>';
        dd($items_dates);

        // diff -> create new item
    }

    public function delete_schedule($id)
    {
        $schedule = Schedule::with(['students', 'items'])->find($id);
        $schedule->students->each(function ($item) {
            $item->forceDelete();
        });
        $schedule->items->each(function ($item) {
            $item->forceDelete();
        });
        $schedule->forceDelete();
        return redirect('/' . $this->modal);
    }


    public function add_item($id, Request $request)
    {
        $schedule = Schedule::find($id);
        $schedule->items()->create([
            'session_date' => $request['session_date'],
            'session_start_time' => $request->session_start_time,
            'session_end_time' => $request->session_end_time
        ]);
    }

    public function update_item($id, $item_id, Request $request)
    {
        $schedule = Schedule::find($id);
        $item = $schedule->items()->find($item_id);
        $item->update([
            'session_date' => $request['session_date'],
            'session_start_time' => $request->session_start_time,
            'session_end_time' => $request->session_end_time
        ]);
    }

    public function delete_item($id, $item_id)
    {
        $schedule = Schedule::find($id);
        $item = $schedule->items()->find($item_id);
        $item->delete();
    }
}
