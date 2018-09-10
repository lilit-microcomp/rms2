<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('roles')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);*/



        DB::table('roles')->delete();

        $countries = array(
            array(
                'id' => 1,
                'name' => 'Admin',
                'fullname' => 'Administrator',
                'description' => 'administrator'
            ),
            array(
                'id' => 2,
                'name' => 'PM',
                'fullname' => 'Project Manager',
                'description' => 'pmanager'
            ),
            array(
                'id' => 3,
                'name' => 'Developer',
                'fullname' => 'Developer',
                'description' => 'developer'
            ),
            array(
                'id' => 4,
                'name' => 'Lead',
                'fullname' => 'Team Lead',
                'description' => 'teamlead'
            ),
            array(
                'id' => 5,
                'name' => 'Freelance',
                'fullname' => 'Freelance',
                'description' => 'freelance'
            )
        );
        DB::table('roles')->insert($countries);
    }

}











