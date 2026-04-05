<?php
// app/Services/AchievementService.php
namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Events\AchievementUnlocked;

class AchievementService
{
    public function check(User $user, string $type): void
    {
        $value = match($type) {
            'time_played'     => $user->totalMinutesPlayed(),
            'games_completed' => $user->gamesCompleted(),
            default           => 0,
        };

        $alreadyUnlocked = $user->achievements()->pluck('achievement_id');

        Achievement::where('type', $type)
            ->where('threshold', '<=', $value)
            ->whereNotIn('id', $alreadyUnlocked)
            ->get()
            ->each(function (Achievement $achievement) use ($user) {
                $user->achievements()->attach($achievement->id, [
                    'unlocked_at' => now(),
                ]);
                event(new AchievementUnlocked($user, $achievement));
            });
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