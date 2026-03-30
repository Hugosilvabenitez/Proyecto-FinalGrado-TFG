<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SaveStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('save_states')->insert([
            [
                'user_id' => 1,
                'rom_id' => 1,
                'slot_number' => 1,
                'save_name' => 'Save State 1',
                'save_path' => '/path/to/save/state1.sav',
            ],
            [
                'user_id' => 2,
                'rom_id' => 2,
                'slot_number' => 2,
                'save_name' => 'Save State 2',
                'save_path' => '/path/to/save/state2.sav',
            ],
            [
                'user_id' => 3,
                'rom_id' => 3,
                'slot_number' => 3,
                'save_name' => 'Save State 3',
                'save_path' => '/path/to/save/state3.sav',
            ]
        ]);
    }
}
