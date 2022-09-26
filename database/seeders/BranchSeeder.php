<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $branch_names = [
            'Bimbel - Jakarta Timur',
            'Bimbel - Jakarta Barat',
            'Bimbel - Jakarta Utara',
            'Bimbel - Jakarta Selatan'
        ];

        for (
            $x = 0;
            $x < count($branch_names);
            $x++
        ) {
            $branch = [
                'name' => $branch_names[$x],
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'manager_id' => fake()->numberBetween($min = 1, $max = 10),
                'email' => fake()->unique()->safeEmail(),
                'open_date' => fake()->date(),
                'status' => fake()->text(10),
            ];

            DB::table('branches')->insert($branch);
        }
    }
}
