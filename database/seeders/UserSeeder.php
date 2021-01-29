<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@tasks.pl',
            'password' => Hash::make('tasks123'),
            'role' => 'admin'
        ]);

        DB::table('users')->insert([
            'name' => 'Client',
            'email' => 'client@tasks.pl',
            'password' => Hash::make('tasks456'),
            'role' => 'client'
        ]);


    }
}
