<?php

use Illuminate\Database\Seeder;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->delete();

        $event_types = [
            ['type'=>'Public'],
            ['type'=>'Reservation'],
            ['type'=>'HOA_Administrative']
        ];

        DB::table('event_types')->insert($event_types);
    }
}
