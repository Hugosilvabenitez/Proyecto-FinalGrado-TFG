<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
* Class UserRomSeeder (Seeder)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This seeder links users with ROMs in the corresponding pivot table.
*/
class UserRomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roms')->insert([
            [
                'user_id' => 1,
                'rom_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'rom_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'rom_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
