<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return response(["data" => $comments]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required|string',
            'type' => 'required|in:post,comment',
            'commentable_id' => 'required|integer'
        ]);

        $comment = new Comment;
        $comment->body = trim($validatedData['body']);
        $comment->user_id = $request->user()->id;

        if ($validatedData['type'] === 'post') {
            $comment->commentable_type = 'App\Models\Post';
        } else {
            $comment->commentable_type = 'App\Models\Comment';
        }

        $comment->commentable_id = $validatedData['commentable_id'];
        $comment->save();

        return response([
            "message" => "Comment Created",
            "data" => $comment
        ], 201);
    }
    public function show($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail();

        return response([
            "data" => $comment->load(['comments.comments'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'body' => 'string',
        ]);

        $comment = Comment::where('id', $id)->firstOrFail();

        $comment->update($validatedData);

        return response([
            "message" => "Comment Updated",
            "data" => $comment
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail();
        $comment->delete();
        return response([
            "message" => "Comment Deleted",
        ]);
    }


    // Test
    public function getUrl()
    {
        return response([
            "data" => url()->current()
        ]);
    }
}
