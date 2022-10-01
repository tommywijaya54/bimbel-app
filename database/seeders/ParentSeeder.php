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
        for ($x = 1; $x <= 4; $x++) {
            $people = [
                'nik' => fake('id_ID')->numerify('CPA-###-###-###'),
                'name' => fake('id_ID')->name(),
                'address' => fake('id_ID')->address(),
                'phone' => fake('id_ID')->phoneNumber(),
                'email' => fake('id_ID')->unique()->safeEmail(),
                'birth_date' => fake('id_ID')->date(),
                'emergency_name' => fake('id_ID')->name(),
                'emergency_phone' => fake('id_ID')->phoneNumber(),
                'bank_account_name' => fake('id_ID')->text(),
                'virtual_account_name' => fake('id_ID')->text(),
                'note' => fake('id_ID')->text(50),
                'user_id' => fake('id_ID')->numberBetween($min = 15, $max = 30),
                'blacklist' => fake('id_ID')->randomElement(['true', 'false']),
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
