<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'comment' => 'required|string|max:2000',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'comment' => $request->comment,
            'status'  => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted for approval.',
            'comment' => $comment
        ]);
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Comment approved.']);
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Comment rejected.']);
    }
}
