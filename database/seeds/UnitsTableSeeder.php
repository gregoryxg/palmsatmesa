<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->delete();

        for ($i=1000;$i<1401;$i++)
        {
            DB::table('units')->insert([
                'id'=>$i
            ]);
        }
    }
}
