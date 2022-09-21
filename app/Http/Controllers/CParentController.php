<?php

namespace App\Http\Controllers;

use App\Models\Cparent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CparentController extends Controller
{
    public function index()
    {
        $data = Cparent::all();
        return Inertia::render('Simple/Index', [
            'pagetitle' => "Cparent List",
            'data' => $data,
            'route' => 'cparent.edit',
            'view' => "name,address,phone"
        ]);
    }

    public function create()
    {
        return Inertia::render('Cparent/Create');
    }

    public function store(Request $request)
    {
        Cparent::create([
            'nik' => $request['nik'],
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'birth_date' => $request['birth_date'],
            'emergency_name' => $request['emergency_name'],
            'emergency_phone' => $request['emergency_phone'],
            'bank_account_name' => $request['bank_account_name'],
            'virtual_account_name' => $request['virtual_account_name'],
            'note' => $request['note'],
            'user_id' => $request['user_id'],
            'blacklist' => $request['blacklist'],
        ]);
    }


    public function edit($id)
    {
        $data = Cparent::find($id);
        return Inertia::render('Cparent/Edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $entity = Cparent::find($id);
        $entity->nik = $request->nik;
        $entity->name = $request->name;
        $entity->address = $request->address;
        $entity->phone = $request->phone;
        $entity->email = $request->email;
        $entity->birth_date = $request->birth_date;
        $entity->emergency_name = $request->emergency_name;
        $entity->emergency_phone = $request->emergency_phone;
        $entity->bank_account_name = $request->bank_account_name;
        $entity->virtual_account_name = $request->virtual_account_name;
        $entity->note = $request->note;
        $entity->user_id = $request->user_id;
        $entity->blacklist = $request->blacklist;

        $entity->update();
        return Redirect::route('cparent.index');
    }

    public function destroy(Cparent $cparent)
    {
        $cparent->delete();
        return Redirect::back()->with('message', 'Cparent deleted.');
    }
}
