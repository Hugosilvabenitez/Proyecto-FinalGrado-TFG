<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Events\CommentCreated;
use Illuminate\Http\RedirectResponse;

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
    /**
     * Store a newly created comment and broadcast it.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $validated['post_id'],
            'content' => $validated['content'],
        ]);

        $comment->load('user');

        broadcast(new CommentCreated($comment));

        return back();
    }
}
