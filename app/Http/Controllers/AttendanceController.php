<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\ScheduleItem;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        $list = Schedule::with(['items', 'teacher' => function ($query) {
            $query->select('id', 'name');
        }])->where('teacher_id', auth()->user()->id)->get();
        return Inertia::render('Attendance/List', [
            'schedules' => $list
        ]);
    }

    public function show($session_id)
    {
        $session = ScheduleItem::find($session_id);
        $schedule = Schedule::with('students', 'teacher')->find($session->schedule_id);
        $students = User::find($schedule->students->pluck('student_id'));
        $attendance = Attendance::where('schedule_item_id', $session_id)->get();

        return Inertia::render('Attendance/Show', [
            'session' => $session,
            'schedule' => $schedule,
            'students' => $students,
            'attendance' => $attendance
        ]);
    }

    public function add_attendance($session_id, Request $request)
    {
        Attendance::create([
            'student_id' => $request['student_id'],
            'present' => $request['present'],
            'schedule_item_id' => $session_id,
            'teacher_id' => auth()->user()->id
        ]);
    }

    public function delete_attendance($id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();
    }
}
