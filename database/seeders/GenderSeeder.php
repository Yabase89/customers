<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gender')->insert([
            'gender' => 'Male',
            'status' => '1'
        ]);
        DB::table('gender')->insert([
            'gender' => 'Female',
            'status' => '1'
        ]);
        DB::table('gender')->insert([
            'gender' => 'Other',
            'status' => '1'
        ]);
    }
}
