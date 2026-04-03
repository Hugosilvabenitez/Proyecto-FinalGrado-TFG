<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
       

        DB::table('achievements')->insert([
            ['name' => 'Primeros pasos',   'description' => 'Juega 10 minutos en total',  'icon' => '👟', 'type' => 'time_played',     'threshold' => 10,    'points' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jugador habitual', 'description' => 'Juega 60 minutos en total',  'icon' => '🕹️', 'type' => 'time_played',     'threshold' => 60,    'points' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maratoniano',      'description' => 'Juega 300 minutos en total', 'icon' => '🏅', 'type' => 'time_played',     'threshold' => 300,   'points' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Primera victoria', 'description' => 'Completa tu primer juego',   'icon' => '🥇', 'type' => 'games_completed', 'threshold' => 1,     'points' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Coleccionista',    'description' => 'Completa 5 juegos',           'icon' => '🎖️', 'type' => 'games_completed', 'threshold' => 5,     'points' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Puntuador',        'description' => 'Alcanza 10.000 puntos',       'icon' => '💯', 'type' => 'in_game',         'threshold' => 10000, 'points' => 30, 'created_at' => now(), 'updated_at' =>  now()],
        ]);
    }
}