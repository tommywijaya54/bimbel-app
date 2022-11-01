<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\SyncRelatedItem;
use Illuminate\Http\Request;
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

        $studentSync = new SyncRelatedItem($schedule, 'students', 'student_id');
        $studentSync->syncItems($request->students_id);

        $itemsSync = new SyncRelatedItem($schedule, 'items', 'id', [
            'new' => function ($item) {
                return $item['item'];
            },
            'compare' => [
                'new' => function ($requestItems) {
                    return $requestItems->filter(function ($item) {
                        return empty($item['id']);
                    });
                }
            ]
        ], false);
        $itemsSync->syncItems(collect($request->items)->map(function ($item) {
            return [
                'id' => $item['id'],
                'session_date' => explode(' ', $item['session_date'])[0],
                'session_start_time' => explode(' ', $item['session_start_time'])[1],
                'session_end_time' => explode(' ', $item['session_end_time'])[1],
                'item' => $item
            ];
        }));
        return redirect('/' . $this->modal . '/' . $schedule->id);
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
}
