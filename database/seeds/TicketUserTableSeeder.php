<?php

use Illuminate\Database\Seeder;

class TicketUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_user')->delete();

        $ticket_user = [
            ['ticket_id'=>1, 'user_id'=>1],
            ['ticket_id'=>2, 'user_id'=>1],
            ['ticket_id'=>3, 'user_id'=>1],
            ['ticket_id'=>4, 'user_id'=>1],
            ['ticket_id'=>5, 'user_id'=>1],
        ];

        DB::table('ticket_user')->insert($ticket_user);
    }
}
