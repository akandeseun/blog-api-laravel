<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function index()
    {
        $tags = Tag::all();

        return response(["data" => $tags]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $tag = new Tag;
        $tag->name = $validatedData['name'];

        $tag->save();

        return response([
            "message" => "Tag Created",
            "data" => $tag
        ], 201);
    }

    public function show($id)
    {
        $tag = Tag::where('id', $id)->firstOrFail();

        return response([
            "data" => $tag
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $tag = Tag::where('id', $id)->firstOrFail();

        $tag->name = $validatedData['name'];
        $tag->save();

        return response([
            "message" => "Tag Updated",
            "data" => $tag
        ]);
    }

    public function destroy($id)
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        $tag->delete();
        // $tag->save();
        return response([
            "message" => "Tag Deleted",
        ]);
    }
}
