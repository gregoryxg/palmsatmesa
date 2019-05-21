<?php

use Illuminate\Database\Seeder;

class TicketCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_comments')->delete();

        $ticket_comments = [

            ['comment'=>'Administration and Accounting Comment',
                'ticket_id'=>1,
                'user_id'=>1],
            ['comment'=>'Community Events and Outreach Comment',
                'ticket_id'=>2,
                'user_id'=>1],
            ['comment'=>'Landscape and Maintenance Comment',
                'ticket_id'=>3,
                'user_id'=>1],
            ['comment'=>'Safety and Security Comment',
                'ticket_id'=>4,
                'user_id'=>1],
            ['comment'=>'Website and Technical Support Comment',
                'ticket_id'=>5,
                'user_id'=>1]
        ];

        DB::table('ticket_comments')->insert($ticket_comments);
    }
}
