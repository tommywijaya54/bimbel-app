<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function show(Employee $employee)
    {
        return Inertia::render('Employee/Show', [
            'employee' => $employee
        ]);
    }
}
