<?php

use Illuminate\Database\Seeder;

class ReservablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reservables')->delete();
        
        \DB::table('reservables')->insert(array (
            0 => 
            array (
                'id' => 1,
                'description' => 'Clubhouse Kitchen / Pool Table / Living Room',
                'guest_limit' => 30,
                'reservation_fee' => 5000,
                'security_deposit' => 25000,
                'backgroundColor' => '#010D56',
                'textColor' => '#FFFFFF',
                'active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'description' => 'Clubhouse Theater Room',
                'guest_limit' => 13,
                'reservation_fee' => 2000,
                'security_deposit' => 25000,
                'backgroundColor' => '#015613',
                'textColor' => '#FFFFFF',
                'active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}