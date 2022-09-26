<?php

namespace Database\Seeders;

use App\Models\Branch;
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

            $user = [
                'name' => $people['name'],
                'email' => $people['email'],
                'type' => 'Employee',
                'password' => 'xxx - employee'
            ];

            $User = User::create($user);

            $people['user_id'] = $User->id;
            $people['branche_id'] = $Branches->random()->id;

            DB::table('employees')->insert($people);
        }
    }
}
