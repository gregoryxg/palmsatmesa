<?php

use Illuminate\Database\Seeder;

class ResidentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resident_statuses')->delete();

        $resident_status = [
            ['status'=>'Homeowner', 'add_to_calendar'=>true],
            ['status'=>'Lessee', 'add_to_calendar'=>false]
        ];

        DB::table('resident_statuses')->insert($resident_status);
    }
}
