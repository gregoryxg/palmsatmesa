<?php

use Illuminate\Database\Seeder;

class ReservableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservable')->delete();

        $reservable = [
            ['description'=>'Clubhouse Kitchen'],
            ['description'=>'Clubhouse Pool Room'],
            ['description'=>'Clubhouse Theater Room']
        ];

        DB::table('reservable')->insert($reservable);
    }
}
