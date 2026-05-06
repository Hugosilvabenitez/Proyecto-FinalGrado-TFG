<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
* Class EmulatorSeeder (Seeder)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This seeder inserts the emulator records available in the platform.
*/
class EmulatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('emulators')->insert([
            [
                'name' => 'Emulador 1',
                'version' => '1.0',
                'wasm_path' => '/path/to/emulator1.wasm',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Emulador 2',
                'version' => '1.0',
                'wasm_path' => '/path/to/emulator2.wasm',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Emulador 3',
                'version' => '1.0',
                'wasm_path' => '/path/to/emulator3.wasm',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
