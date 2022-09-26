<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 1; $x <= 10; $x++) {
            $people = [
                'nik' => fake()->numerify('CPA-###-###-###'),
                'name' => fake()->name(),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'birth_date' => fake()->date(),
                'emergency_name' => fake()->name(),
                'emergency_phone' => fake()->phoneNumber(),
                'bank_account_name' => fake()->text(),
                'virtual_account_name' => fake()->text(),
                'note' => fake()->text(50),
                'user_id' => fake()->numberBetween($min = 15, $max = 30),
                'blacklist' => fake()->randomElement(['true', 'false']),
            ];

            $user = [
                'name' => $people['name'],
                'email' => $people['email'],
                'type' => 'Parent',
                'password' => 'xxx'
            ];

            $User = User::create($user);
            $people['user_id'] = $User->id;

            DB::table('cparents')->insert($people);
        }
    }
}
