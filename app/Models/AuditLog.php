<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AuditLog (Model)
 * 
 * @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
 * @date 2026-03-09
 * 
 * This class contains all the relationships, accessors, mutators, and fields necessary for the AuditLog model.
 */

class AuditLog extends Model
{
    /**
     * ONE LOG BELONGS TO AN USER
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
