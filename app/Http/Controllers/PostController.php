<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response(["data" => $posts]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'required|string',
            'body' => 'required|string',
        ]);

        $post = new Post;
        $post->title = trim($validatedData['title']);
        $post->excerpt = trim($validatedData['excerpt']);
        $post->body = trim($validatedData['body']);

        $post->save();

        return response([
            "message" => "Post Created",
            "data" => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        return response([
            "data" => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string',
            'excerpt' => 'string',
            'body' => 'string',
        ]);

        $post = Post::where('id', $id)->firstOrFail();

        $post->update($validatedData);

        // $post->title = $validatedData['title'];
        // $post->excerpt = $validatedData['excerpt'];
        // $post->body = $validatedData['body'];
        // $post->save();

        return response([
            "message" => "Post Updated",
            "data" => $post
        ]);
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $post->delete();
        return response([
            "message" => "Post Deleted",
        ]);
    }
}
