<?php

namespace Database\Seeders;

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
        $permissions = [
            'create-users',
            'edit-users',
            'delete-users',
        ];
        foreach ($permissions as $value) {
            Permission::create(['name' => $value]);
        }

        $roles = ['Owner', 'Super Admin', 'Branch Manager', 'Advisor', 'Teacher', 'HRD', 'Finance'];
        foreach ($roles as $value) {
            Role::create(['name' => $value]);
        }

        //$superAdminRole = Role::create(['name' => 'Super Admin']);
        //$adminRole = Role::create(['name' => 'Admin']);

        $superAdminRole = Role::findByName('Super Admin');
        $managerRole = Role::findByName('Branch Manager');

        $superAdminRole->givePermissionTo($permissions);
        $managerRole->givePermissionTo($permissions);
    }
}
