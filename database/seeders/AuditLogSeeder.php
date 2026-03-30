<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('audit_logs')->insert([
            [
                'user_id' => 1,
                'action' => 'User logged in',
                'entity_type' => 'User',
                'entity_id' => 1,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'action' => 'User logged out',
                'entity_type' => 'User',
                'entity_id' => 2,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'action' => 'User updated settings',
                'entity_type' => 'UserSetting',
                'entity_id' => 1,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
