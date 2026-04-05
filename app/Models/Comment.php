<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Class Comment (Model)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-30
* 
* This class contains all the relationships, accessors, mutators, and fields necessary for the Comment model.
*/

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
