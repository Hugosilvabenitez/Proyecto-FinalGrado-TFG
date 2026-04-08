<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
* Class UserStat (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-04-08
* 
* This class contains all the necessary functions for the User's stats Model.
*/

class UserStat extends Model
{
    protected $table = 'users_stats';

    protected $fillable = [
        'user_id',
        'total_minutes',
        'cloud_saves',
        'achievements_unlocked'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
