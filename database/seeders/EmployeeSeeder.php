<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $Branches = Branch::all();

        for ($x = 1; $x <= 5; $x++) {
            $people = [
                'nik' => fake('id_ID')->randomDigit() . '99-999-Employee',
                'name' => fake('id_ID')->name(),
                'address' => fake('id_ID')->address(),
                'phone' => fake('id_ID')->phoneNumber(),
                'email' => fake('id_ID')->unique()->safeEmail(),
                'emergency_name' => fake('id_ID')->name(),
                'emergency_phone' => fake('id_ID')->phoneNumber(),
                'join_date' => fake('id_ID')->date(),
                'exit_date' => fake('id_ID')->date(),
                'note' => fake('id_ID')->text(50),
            ];

            $user_data = [
                'name' => $people['name'],
                'email' => $people['email'],
                'type' => 'Employee',
                'password' => 'xxx - employee'
            ];

            $user = User::create($user_data);
            $user->assignRole('Employee');

            $people['user_id'] = $user->id;
            $people['branch_id'] = $Branches->random()->id;

            Employee::create($people);
        }

        $employees = Employee::all();
        $employees->each(function ($employee, $key) {
            for ($y = 1; $y <= 5; $y++) {
                $salary = [
                    'start_date' => fake('id_ID')->date(),
                    'amount' => fake('id_ID')->randomElement([3200000, 47000000, 5500000]),
                ];
                $employee->salaries()->create($salary);
            }
        });
    }
}
