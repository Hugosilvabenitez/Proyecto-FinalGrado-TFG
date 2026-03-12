<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
* Class Role (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-09
* 
* This class contains all the relationships, accessors, mutators, and fields necessary for the Role model.
*/

class Role extends Model
{
    protected $fillable = [
    'name',
    'description'
    ];
/**
* ONE ROLE BELONGS TO MANY USERS
*/
    public function users(): BelongsToMany
    {
    return $this->belongsToMany(User::class, 'role', 'role_id', 'user_id');
    }
}



