<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimetableController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return Inertia::render('Timetable/Show', [
            'schedules' => $user->schedules()
        ]);
    }
}
