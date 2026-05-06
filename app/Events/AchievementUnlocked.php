<?php
// app/Events/AchievementUnlocked.php
namespace App\Events;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Foundation\Events\Dispatchable;

/**
* Class AchievementUnlocked (Event)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This event is dispatched when a user unlocks an achievement.
*/
class AchievementUnlocked
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Achievement $achievement
    ) {}
}
