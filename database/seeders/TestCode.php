<?php

namespace Database\Seeders;

use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestCode extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        // clear;
        echo 'Test';
        echo "\r\n";

        // echo DB::table('role_has_permissions')->where('role_id', 2)->get();
        // echo Role::permissions();

        echo User::findByName('Tony');

        echo "\r\n";
        echo "\r\n";
        echo "\r\n";
    }
}
