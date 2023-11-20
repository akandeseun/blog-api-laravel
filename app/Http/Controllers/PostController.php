<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('comments')->get();

        return response(["data" => $posts]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'category_id' => 'required|integer',
            'tag_id' => 'required|integer',
        ]);

        $post = new Post;
        $post->title = trim($validatedData['title']);
        $post->body = trim($validatedData['body']);
        $post->category_id = $validatedData['category_id'];
        $post->tag_id = $validatedData['tag_id'];

        $post->save();



        return response([
            "message" => "Post Created",
            "data" => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::with('comments')->where('id', $id)->firstOrFail();

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
