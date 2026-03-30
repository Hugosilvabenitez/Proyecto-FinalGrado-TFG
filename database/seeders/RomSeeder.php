<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roms')->insert([
            [
                'title' => 'FC-26',
                'slug' => 'rom-1',
                'description' => 'Gran juego de futbol para aquellos que disfrutan de los deportes',
                'file_path' => '/path/to/rom1.rom',
                'cover_image' => '/path/to/cover1.jpg',
                'size_bytes' => 1024,
                'region' => 'NTSC',
                'emulator_id' => 1,
                'uploaded_by' => 1,
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Call of Duty',
                'slug' => 'rom-2',
                'description' => 'Accion y disparos en un entorno realista, ideal para los amantes de la adrenalina',
                'file_path' => '/path/to/rom2.rom',
                'cover_image' => '/path/to/cover2.jpg',
                'size_bytes' => 2048,
                'region' => 'PAL',
                'emulator_id' => 2,
                'uploaded_by' => 2,
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mario Kart',
                'slug' => 'rom-3',
                'description' => 'Gran juego de carreras para toda la familia, con personajes icónicos y pistas divertidas',
                'file_path' => '/path/to/rom3.rom',
                'cover_image' => '/path/to/cover3.jpg',
                'size_bytes' => 4096,
                'region' => 'NTSC',
                'emulator_id' => 3,
                'uploaded_by' => 3,
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
