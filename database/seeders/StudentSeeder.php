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
        $Schools = School::all();
        $Parents = Cparent::all();

        for (
            $x = 1;
            $x <= 5;
            $x++
        ) {
            $people = [
                'grade' => fake('id_ID')->randomElement(['TKA', 'TKB', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12']),
                'name' => fake('id_ID')->name(),
                'email' => fake('id_ID')->unique()->safeEmail(),
                'phone' => fake('id_ID')->phoneNumber(),
                'address' => fake('id_ID')->address(),
                'join_date' => fake('id_ID')->date(),
                'exit_date' => fake('id_ID')->date(),
                'exit_reason' => fake('id_ID')->randomElement(['', 'Pindah Sekolah - Jauh dari area bimbel']),
                'birth_date' => fake('id_ID')->date(),
                'type' => fake('id_ID')->randomElement(['International', 'National', 'International - National']),
                'health_condition' => fake('id_ID')->sentence(4),
                'note' => fake('id_ID')->text(50),
            ];

            $user = [
                'name' => $people['name'],
                'email' => $people['email'],
                'type' => 'Student',
                'password' => 'yyy - student'
            ];

            $User = User::create($user);
            $User->assignRole('student');

            $people['user_id'] = $User->id;
            $people['cparent_id'] = $Parents->random()->id;
            $people['school_id'] = $Schools->random()->id;

            DB::table('students')->insert($people);
        }
    }
}
