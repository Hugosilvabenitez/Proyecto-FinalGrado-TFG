<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

/**
* Class CommentController (Controller)
* 
* @author Miguel Gordon Jiménez <mgorjim1003@g.educaand.es>
* @date 2026-03-30
* 
* This class contains all the necessary functions for the Comment's Controller.
*/

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'post_id' => 'required'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content
        ]);

        return back();
    }
}
