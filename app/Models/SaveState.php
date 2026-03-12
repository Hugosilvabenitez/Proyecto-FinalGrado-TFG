<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
* Class SaveState (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-09
* 
* This class contains all the relationships, accessors, mutators, and fields necessary for the SaveState model.
*/

class SaveState extends Model
{
    protected $fillable = [
        'user_id',
        'rom_id',
        'slot_number',
        'save_name',
        'save_path'
    ];
/**
* ONE PARTIE SAVED BELONGS TO AN USER
*/
    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }

    /**
    * ONE PARTIE SAVED BELONGS TO AN USER
    */
    public function rom(): BelongsTo
    {
    return $this->belongsTo(Rom::class);
    }
}
