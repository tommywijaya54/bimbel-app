<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{
    //

    public function index()
    {
        $data = Branch::all();
        return Inertia::render('Simple/Index', [
            'pagetitle' => "Branches List",
            'data' => $data,
            'goto' => 'branch',
            'view' => "id,name,phone,address,email"
        ]);
    }
}
