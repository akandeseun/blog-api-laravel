<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response(["data" => $categories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];

        $category->save();

        return response([
            "message" => "Category Created",
            "data" => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        return response([
            "data" => $category->posts
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::where('id', $id)->firstOrFail();

        $category->name = $validatedData['name'];
        $category->save();

        return response([
            "message" => "Category Updated",
            "data" => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        $category->delete();
        return response([
            "message" => "Category Deleted",
        ]);
    }
}
