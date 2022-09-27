<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = ['Owner', 'super-admin', 'Branch Manager', 'Advisor', 'Teacher', 'HRD', 'Finance'];
        foreach ($roles as $value) {
            Role::create(['name' => $value]);
        }


        $super_admin_permissions = [
            'list-user',
            'show-user',
            'create-user',
            'edit-user',
            'deactivate-user',
            'activate-user',
            'reset password-user'
        ];

        $owner_permissions = [
            'list-role and permission',
            'show-role',
            'edit-role',
            'deactivate-branch',
            'create-branch',
            'edit-branch',
            'delete-branch'
        ];

        $manager_permissions = [
            'list-branch',
            'show-branch',
            'add-branch-expenses',
            'list-employee',
            'show-employee',
            'create-employee',
            'edit-employee',
            'deactivate-employee',
            'activate-employee'
        ];

        $advisor_permissions = [
            'list-registration',
            'show-registration',
            'create-registration',
            'edit-registration',
            'delete-registration',

            'list-student',
            'show-student',
            'create-student',
            'edit-student',

            'list-parent',
            'show-parent',
            'create-parent',
            'edit-parent',
        ];

        // $permissions + $manager_permissions + $advisor_permissions;

        $all_permissions =  array_merge($super_admin_permissions,  $owner_permissions, $manager_permissions, $advisor_permissions);

        // echo "\r\n";
        // echo $all_permissions;

        //echo '<pre>';
        // print_r($all_permissions);


        foreach ($all_permissions as $value) {
            $prm = Permission::create(['name' => $value]);
            echo "\r\n Permission Created : ";
            echo $prm->name;
        }

        //echo '</pre>';

        Role::findByName('Owner')->givePermissionTo($all_permissions);
        Role::findByName('super-admin')->givePermissionTo($super_admin_permissions);
        Role::findByName('Branch Manager')->givePermissionTo($manager_permissions);
        Role::findByName('Advisor')->givePermissionTo($advisor_permissions);
    }
}
