<?php

namespace Database\Seeders;

use App\Models\Cparent;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $Schools = School::all();
        $Parents = Cparent::all();

        for (
            $x = 1;
            $x <= 20;
            $x++
        ) {
            $people = [
                'grade' => fake()->randomElement(['TKA', 'TKB', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12']),
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'join_date' => fake()->date(),
                'exit_date' => fake()->date(),
                'exit_reason' => fake()->randomElement(['', 'Pindah Sekolah - Jauh dari area bimbel']),
                'birth_date' => fake()->date(),
                'type' => fake()->randomElement(['International', 'National', 'International - National']),
                'health_condition' => fake()->sentence(4),
                'note' => fake()->text(50),
            ];

            $user = [
                'name' => $people['name'],
                'email' => $people['email'],
                'type' => 'Student',
                'password' => 'yyy - student'
            ];

            $User = User::create($user);

            $people['users_id'] = $User->id;
            $people['cparents_id'] = $Parents->random()->id;
            $people['schools_id'] = $Schools->random()->id;

            DB::table('students')->insert($people);
        }
    }
}
