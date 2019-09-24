<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UnitsTableSeeder::class);
        $this->call(ResidentStatusesTableSeeder::class);
        $this->call(EventTypesTableSeeder::class);
        $this->call(ReservablesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VerifyUsersTableSeeder::class);
        $this->call(CommitteesTableSeeder::class);
        $this->call(CommitteeUserTableSeeder::class);
        $this->call(TicketTypesTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
        $this->call(TicketUserTableSeeder::class);
        $this->call(TicketCommentsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
    }
}
