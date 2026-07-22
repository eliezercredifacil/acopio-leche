<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('localidads')->insert([
            [
                'nombre' => 'Los Angeles',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'La Flor',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Caño Blanco',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'El Cascal',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Rio Plata',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Las Vegas',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'San Francisco',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'La Bocana',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
