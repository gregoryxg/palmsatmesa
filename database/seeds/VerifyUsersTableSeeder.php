<?php

use Illuminate\Database\Seeder;

class VerifyUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('verify_users')->delete();

        $verify_users = [
            ['token' => sha1(time())],
            ['token' => sha1(time())]
        ];

        DB::table('verify_users')->insert($verify_users);
    }
}
