<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Rom (Model)
 * 
 * @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
 * @date 2026-03-09
 * 
 * This class contains all the relationships, accessors, mutators, and fields necessary for the Rom model.
*/

class Rom extends Model
{
    /**
     * ONE ROM BELONGS TO AN EMULATOR
     */
    public function emulator(): BelongsTo
    {
        return $this->belongsTo(Emulator::class);
    }

    /**
     * ONE ROM BELONGS TO THE USER THAT UPLOADED IT
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * ONE ROM CAN HAVE MANY PARTIES SAVED
     */
    public function saveStates(): HasMany
    {
        return $this->hasMany(SaveState::class);
    }
}
