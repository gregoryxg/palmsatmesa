<?php

use Illuminate\Database\Seeder;

class ResidentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resident_status')->delete();

        $resident_status = [['resident_status'=>'Homeowner'],['resident_status'=>'Lessee']];

        DB::table('resident_status')->insert($resident_status);
    }
}
