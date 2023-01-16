<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    
        DB::table('users')->insert(['name' => 'Zara Bostock',
                                    'email' => 'zara.bostock@mega-electrical.co.uk',
                                    'phone' => '01234567891',
                                    'type_id' => '1',
                                    'company_id' => '1',
                                    'password' => 'Password']);
    }
}
