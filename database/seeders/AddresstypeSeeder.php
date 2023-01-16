<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AddresstypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresstype')->insert([
            'address_type' => 'Billing Address',
            'status' => '1'
        ]);
        DB::table('addresstype')->insert([
            'address_type' => 'Shipping Address',
            'status' => '1'
        ]);
    }
}
