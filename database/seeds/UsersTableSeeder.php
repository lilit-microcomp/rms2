<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Lilit',
            'lastname' => 'Matshkalyan',
            'email' => 'lil.matshkalyan@gmail.com',
            'password' => bcrypt('qwerty'),
            'role_id' => 1,
            'role_name' => 'Admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
