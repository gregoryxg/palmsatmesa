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

        $resident_status = [['status'=>'Homeowner'],['status'=>'Lessee']];

        DB::table('resident_statuses')->insert($resident_status);
    }
}
