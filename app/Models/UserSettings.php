<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserSettings (Model)
 * 
 * @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
 * @date 2026-03-09
 * 
 * This class contains all the relationships, accessors, mutators, and fields necessary for the UserSettings model.
*/

class UserSettings extends Model
{
    /**
     * ONE SETTING BELONGS TO AN USER
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
