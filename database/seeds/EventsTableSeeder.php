<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();

        /*$table->increments('id');
        $table->string('title');
        $table->unsignedInteger('reservable_id');
        $table->unsignedInteger('size');
        $table->date('date');
        $table->unsignedInteger('timeslot_id');
        $table->boolean('event_approved')->default(false);
        $table->unsignedInteger('approved_by');
        $table->unsignedInteger('user_id');
        $table->timestamps();*/

        $events = [
            ['title'=>'Test Event 1',
                'reservable_id'=> 1,
                'size'=> 10,
                'date'=> '2019-05-30',
                'timeslot_id'=>17,
                'event_approved'=>true,
                'approved_by'=>1,
                'user_id'=>1]
        ];

        DB::table('events')->insert($events);
    }
}
