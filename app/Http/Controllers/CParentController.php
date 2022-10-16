<?php

namespace App\Http\Controllers;

use App\Models\Cparent;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CparentController extends CommonController
{
    public $modal = 'parent';

    function __construct()
    {
        parent::__construct(
            [
                'list' => 'id:ID,nik:NIK,name:Parent Name,phone,blacklist',
                'form' => 'nik:NIK,name,address,phone,email,birth_date,emergency_name,emergency_phone,bank_account_name,virtual_account_name,note,blacklist,password:User login password',
            ],
            true
        );

        $this->form->title_format = "{nik} / {name}";
        $this->form->field('password')->extrafield = true;
    }

    function show($id)
    {
        // dd($this->entity::with('students')->get()->toArray());
        // dd($this->entity::find(1)->students->toArray());
        $form_data = $this->form->displayForm($id);
        return Inertia::render('Parent/Show', [
            'title' => $form_data->title,
            'form_schema' => $form_data,
            'students' => $this->entity::find($id)->students->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:cparents',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $controller = $this;
        DB::transaction(
            function () use ($controller, $request) {
                $cparent = $controller->entity::create($controller->form->setStoreOrUpdate($request));

                $user = User::firstOrNew(['email' =>  $request['email']]);
                $user->name = $request['name'];
                $user->type = 'Parent';
                $user->password = bcrypt($request['password']);
                $user->save();

                $cparent->user_id = $user->id;
                $cparent->update();
            }
        );

        return redirect('/' . $this->modal);
    }

    public function update(Request $request, $id)
    {
        $cparent = $this->entity::find($id);

        $request->validate([
            'nik' => 'required|unique:cparents,nik,' . $id,
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users,email,' . $cparent->user_id,
        ]);

        $controller = $this;
        DB::transaction(function () use ($controller, $request, $id, $cparent) {
            $controller->form->setStoreOrUpdate($request, $controller->entity::find($id))->update();

            $user = User::find($cparent->user_id);
            $user->name = $request->name;
            $user->email = $request->email;

            if (isset($request->password)) {
                $user->password = bcrypt($request['password']);
            }

            $user->update();
        });

        return redirect('/' . $this->modal . '/' . $id);
    }
}
