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
        $this->call(ReservableSeeder::class);
        $this->call(TimeslotsSeeder::class);
        $this->call(ReservableTimeslotsSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
