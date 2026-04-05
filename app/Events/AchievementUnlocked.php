<?php
// app/Events/AchievementUnlocked.php
namespace App\Events;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Foundation\Events\Dispatchable;

class AchievementUnlocked
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Achievement $achievement
    ) {}
}