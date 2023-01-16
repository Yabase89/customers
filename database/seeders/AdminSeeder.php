<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => 'Yabase James',
            'email' => 'yabase125@gmail.com',
            'status' => '1',
            'password' => md5('admin123'),
        ]);
    }
}
