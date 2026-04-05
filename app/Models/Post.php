<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Class Post (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-30
* 
* This class contains all the relationships, accessors, mutators, and fields necessary for the Post model.
*/

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
