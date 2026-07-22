<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrador',                
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$3k0l7fWN2MhTCbEyAS/TJekLyP8Dzej/MdNk4LCndtnDFXqn47nnC', // password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
