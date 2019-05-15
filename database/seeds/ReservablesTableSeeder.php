<?php

use Illuminate\Database\Seeder;

class ReservablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservables')->delete();

        $reservable = [
            ['description'=>'Clubhouse Kitchen'],
            ['description'=>'Clubhouse Pool Room'],
            ['description'=>'Clubhouse Theater Room']
        ];

        DB::table('reservables')->insert($reservable);
    }
}
