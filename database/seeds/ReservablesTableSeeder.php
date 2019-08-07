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
                'description' => 'Clubhouse Kitchen / Living Room',
                'guest_limit' => 30,
                'backgroundColor' => '##010D56',
                'textColor' => '#FFFFFF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'description' => 'Clubhouse Theater Room',
                'guest_limit' => 13,
                'backgroundColor' => '#015613',
                'textColor' => '#FFFFFF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'description' => 'Clubhouse Pool Table Room',
                'guest_limit' => 6,
                'backgroundColor' => '#561801',
                'textColor' => '#FFFFFF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}