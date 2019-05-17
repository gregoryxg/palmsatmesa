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
        $this->call(TimeslotsTableSeeder::class);
        $this->call(ReservableTimeslotTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
    }
}
