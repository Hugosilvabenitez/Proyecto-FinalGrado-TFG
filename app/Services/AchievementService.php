<?php
namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Events\AchievementUnlocked;

/**
* Class AchievementService (Service)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This service evaluates achievement requirements and unlocks them for the user when conditions are met.
*/
class AchievementService
{
    public function check(User $user, string $type): array
    {
        $stats = $user->stats()->firstOrCreate([], [
            'total_minutes' => 0,
            'cloud_saves' => 0,
            'achievements_unlocked' => 0,
        ]);

        $stats->refresh();

        $value = match($type) {
            'time_played'     => $stats->total_minutes,
            'games_completed' => $stats->cloud_saves,
            default           => 0,
        };

        $alreadyUnlocked = $user->achievements()->pluck('achievement_id');

        $unlocked = [];

        Achievement::where('type', $type)
            ->where('threshold', '<=', $value)
            ->whereNotIn('id', $alreadyUnlocked)
            ->get()
            ->each(function (Achievement $achievement) use ($user, &$unlocked) {

                $user->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                ]);

                $user->stats()->firstOrCreate([], [
                    'total_minutes' => 0,
                    'cloud_saves' => 0,
                    'achievements_unlocked' => 0,
                ])->increment('achievements_unlocked');

                event(new AchievementUnlocked($user, $achievement));

                $unlocked[] = [
                    'id' => $achievement->id,
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'icon' => $achievement->icon,
                    'points' => $achievement->points,
                ];
            });

        return $unlocked;
    }

    public function checkInGame(User $user, int $score): array
    {
        $alreadyUnlocked = $user->achievements()->pluck('achievement_id');
        $unlocked = [];

        Achievement::where('type', 'in_game')
            ->where('threshold', '<=', $score)
            ->whereNotIn('id', $alreadyUnlocked)
            ->get()
            ->each(function (Achievement $achievement) use ($user, &$unlocked) {
                $user->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                ]);
                $user->stats()->firstOrCreate([], [
                    'total_minutes' => 0,
                    'cloud_saves' => 0,
                    'achievements_unlocked' => 0,
                ])->increment('achievements_unlocked');
                event(new AchievementUnlocked($user, $achievement));

                $unlocked[] = [
                    'id' => $achievement->id,
                    'name' => $achievement->name,
                    'description' => $achievement->description,
                    'icon' => $achievement->icon,
                    'points' => $achievement->points,
                ];
            });

        return $unlocked;
    }
}
