<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
* Class User (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-09
* 
* This class contains all the relationships, accessors, mutators, and fields necessary for the User model.
*/

class User extends Authenticatable
{
/** @use HasFactory<\Database\Factories\UserFactory> */
use HasFactory, Notifiable;

/**
* The attributes that are mass assignable.
*
* @var list<string>
*/
    protected $fillable = [
    'username',
    'email',
    'password',
    'avatar_url',
    'email_verified_at',
    'remember_token',
    ];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
    protected $hidden = [
    'password',
    'remember_token',
    ];

/**
* Get the attributes that should be cast.
*
* @return array<string, string>
*/
    protected function casts(): array
    {
    return [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    ];
    }

    /**
    * ONE USER CAN HAVE MANY ROLES
    */
    public function roles(): BelongsToMany
    {
    return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
    * ONE USER CAN HAVE MANY PARTIES SAVED
    */
    public function saveStates(): HasMany
    {
    return $this->hasMany(SaveState::class);
    }

    /**
    * ONE USER HAVE ONE CONFIGURATION
    */
    public function config(): HasOne
    {
    return $this->hasOne(UserSettings::class);
    }

    /**
    * ONE USER CAN GENERATE MANY LOGS
    */
    public function logs(): HasMany
    {
    return $this->hasMany(AuditLog::class);
    }

    /**
    * ONE USER CAN UPLOAD MANY ROLES
    */
    public function roms(): HasMany
    {
    return $this->hasMany(Rom::class, 'uploaded_by');
    }
}
