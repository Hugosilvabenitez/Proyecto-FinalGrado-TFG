<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Achievement (Model)
 *
 * @author Hugo
 */
class Achievement extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'type', 'threshold', 'points'];

    /**
     * ONE ACHIEVEMENT CAN BE UNLOCKED BY MANY USERS
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withPivot('unlocked_at')
                    ->withTimestamps();
    }
}