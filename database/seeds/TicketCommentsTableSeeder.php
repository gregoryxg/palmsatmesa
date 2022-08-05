<?php

use Illuminate\Database\Seeder;

class TicketCommentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ticket_comments')->delete();
        
        
        
    }
}