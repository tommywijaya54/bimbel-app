<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Branches = Branch::all();

        for ($x = 1; $x <= 10; $x++) {
            $arr = [
                'branch_id' => $Branches->random()->id,

                'expense_type' => fake('id_ID')->text(),

                'description' => fake('id_ID')->text(),

                'amount' => fake('id_ID')->numberBetween($min = 1500, $max = 6000),

                'date' => fake('id_ID')->date(),

                'approve_by' => fake('id_ID')->text(),
            ];
            DB::table('branch_expenses')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = [
                'branch_id' => $Branches->random()->id,

                'start_date' => fake('id_ID')->date(),
                'end_date' => fake('id_ID')->date(),

                'amount' => fake('id_ID')->numberBetween($min = 1500, $max = 6000),

                'owner_name' => fake('id_ID')->name(),
                'owner_phone' => fake('id_ID')->phoneNumber(),

                'notaris_name' => fake('id_ID')->name(),
                'notaris_phone' => fake('id_ID')->phoneNumber(),
            ];
            DB::table('branch_rentals')->insert($arr);
        }

        for ($x = 1; $x <= 10; $x++) {
            $arr = [
                'branch_id' => $Branches->random()->id,
                'item_name' => fake('id_ID')->name(),
                'qty' => fake('id_ID')->randomDigitNotNull(),
                'cost' => fake('id_ID')->numberBetween($min = 1500, $max = 6000),
                'note' => fake('id_ID')->text(50),
            ];
            DB::table('branch_assets')->insert($arr);
        }
    }
}
