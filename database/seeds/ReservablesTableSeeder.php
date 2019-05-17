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
            ['description'=>'Clubhouse Kitchen', 'backgroundColor'=>'##010D56', 'textColor'=>'#FFFFFF'],
            ['description'=>'Clubhouse Pool Room', 'backgroundColor'=>'#561801', 'textColor'=>'#FFFFFF'],
            ['description'=>'Clubhouse Theater Room', 'backgroundColor'=>'#015613', 'textColor'=>'#FFFFFF']
        ];

        DB::table('reservables')->insert($reservable);
    }
}
