<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $permissions = [
            ['name' => 'Ver panel admin',      'slug' => 'admin.access',         'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gestionar usuarios',   'slug' => 'users.manage',         'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gestionar ROMs',       'slug' => 'roms.manage',          'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Editar ROMs',          'slug' => 'roms.edit',            'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gestionar logros',     'slug' => 'achievements.manage',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ver estadísticas',     'slug' => 'stats.view',           'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Jugar ROMs públicas',  'slug' => 'roms.play',            'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Usar chat IA',         'slug' => 'chat.use',             'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ver perfil y logros',  'slug' => 'profile.view',         'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('permissions')->insert($permissions);

        // Recuperar IDs por slug
        $p = DB::table('permissions')->pluck('id', 'slug');
        $r = DB::table('roles')->pluck('id', 'name');

        // Admin → todos los permisos
        $adminPerms = $p->values()->map(fn($id) => [
            'permission_id' => $id,
            'role_id'       => $r['Admin'],
        ])->toArray();

        // Moderator
        $modPerms = collect(['roms.edit', 'stats.view', 'roms.play', 'chat.use', 'profile.view'])
            ->map(fn($slug) => ['permission_id' => $p[$slug], 'role_id' => $r['Moderator']])
            ->toArray();

        // User
        $userPerms = collect(['roms.play', 'chat.use', 'profile.view'])
            ->map(fn($slug) => ['permission_id' => $p[$slug], 'role_id' => $r['User']])
            ->toArray();

        DB::table('permission_role')->insert([...$adminPerms, ...$modPerms, ...$userPerms]);
    }
}