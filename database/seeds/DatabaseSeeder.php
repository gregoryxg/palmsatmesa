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
        $this->call(ResidentStatusesSeeder::class);
        $this->call(ReservablesSeeder::class);
        $this->call(TimeslotsSeeder::class);
        $this->call(ReservableTimeslotSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
