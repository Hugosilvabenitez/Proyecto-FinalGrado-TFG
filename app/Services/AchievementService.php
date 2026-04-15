<?php
namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Events\AchievementUnlocked;

class AchievementService
{
    public function check(User $user, string $type): array
    {
        $value = match($type) {
            'time_played'     => $user->stats->total_minutes,
            'games_completed' => $user->stats->cloud_saves,
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

                $user->stats->increment('achievements_unlocked');

                $unlocked[] = $achievement;
            });

        return $unlocked;
    }

    public function checkInGame(User $user, int $score): void
    {
        $alreadyUnlocked = $user->achievements()->pluck('achievement_id');

        Achievement::where('type', 'in_game')
            ->where('threshold', '<=', $score)
            ->whereNotIn('id', $alreadyUnlocked)
            ->get()
            ->each(function (Achievement $achievement) use ($user) {
                $user->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                ]);
                event(new AchievementUnlocked($user, $achievement));
            });
    }
}