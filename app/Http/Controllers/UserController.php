<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends CommonController
{
    function __construct()
    {
        parent::__construct([
            'list' => 'id,name,email,type',
            'form' => 'name,email,type,status,password,disabled:Deactivation Reason'
        ], true);
        $this->form->title_format = '{name}';
        $this->form->field('type')->hasOptions([
            'Employee', 'Student', 'Parent'
        ], 'select');
    }

    public function store(Request $request)
    {
        if (isset($request['password'])) {
            $request['password'] = Hash::make($request->password);
        }
        $this->entity::create($this->form->setStoreOrUpdate($request));
        return redirect('/' . $this->modal);
    }
    public function update(Request $request, $id)
    {
        if (isset($request['password'])) {
            $request['password'] = Hash::make($request->password);
        }
        $this->form->setStoreOrUpdate($request, $this->entity::find($id))->update();
        return redirect('/' . $this->modal . '/' . $id);
    }
}
