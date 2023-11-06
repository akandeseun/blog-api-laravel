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
            'post_id' => 'required|string',
        ]);

        $comment = new Comment;
        $comment->body = trim($validatedData['body']);
        $comment->post_id = $validatedData['post_id'];
        $comment->user_id = $request->user()->id;

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
            "data" => $comment
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
}
