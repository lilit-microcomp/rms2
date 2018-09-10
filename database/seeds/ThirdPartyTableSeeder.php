<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class ThirdPartyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('third_party')->delete();

        $countries = array(
            array(
                'id' => 1,
                'website' => 'TypeKit',
                'username' => 'hayk@micro-comp.com',
                'password' => 'tTsghrid1!',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'id' => 2,
                'website' => 'Gravity Forms',
                'username' => 'hpmc',
                'password' => 'gTsghrid1!',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'id' => 3,
                'website' => 'Goddaddy',
                'username' => 'microcompllc',
                'password' => 'gTsghot1!',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'id' => 4,
                'website' => 'MediaTemple',
                'username' => 'hayk@micro-comp.com',
                'password' => 'mtTsghot1!',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            array(
                'id' => 5,
                'website' => 'Elegant Themes',
                'username' => 'microcomp',
                'password' => 'H6n-Xgf-udS-ScH',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            )

        );
        DB::table('third_party')->insert($countries);
    }
}
