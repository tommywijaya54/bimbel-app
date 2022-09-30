<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($x = 1; $x <= 10; $x++) {
            $arr = ['start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(), 'level' => fake('id_ID')->randomElement(['Discount 30%', 'Grand Opening Discount']), 'school_type' => fake('id_ID')->randomElement(['International', 'National', 'International-National']), 'subject' => fake('id_ID')->sentence(3), 'price' => fake('id_ID')->numberBetween($min = 1500, $max = 6000), 'week' => fake('id_ID')->text(), 'branch_id' => fake('id_ID')->numberBetween($min = 1, $max = 4),];
            DB::table('pricelists')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = ['start_date' => fake('id_ID')->date(), 'end_date' => fake('id_ID')->date(), 'label' => fake('id_ID')->text(), 'discount_value' => fake('id_ID')->randomElement(['30%', '-200000']), 'branch_id' => fake('id_ID')->numberBetween($min = 1, $max = 4),];
            DB::table('promolists')->insert($arr);
        }
    }
}
