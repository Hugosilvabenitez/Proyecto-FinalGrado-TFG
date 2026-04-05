<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
* Class Emulator (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-09
* 
* This class contains all the relationships, accessors, mutators, and fields necessary for the Emulator model.
*/

class Emulator extends Model
{
    protected $fillable = [
    'name',
    'version',
    'wasm_path',
    'is_active'
    ];
/**
* ONE EMULATOR HAVE MANY ROMS
*/
    public function roms(): HasMany
    {
    return $this->hasMany(Rom::class);
    }
}