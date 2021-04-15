<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('category', 'asc')->get();

        return response()->json([
            'message' => 'success',
            'categories' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|unique:categories'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created',
            'category' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->first();

        if(!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'category' => $category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category' => 'required'
        ]);

        $category = Category::where('id', $id)->first();

        $category->category = $validated['category'];
        $category->save();

        return response()->json([
            'message' => 'Category updated',
            'category' => $category
        ], 200);
    }

    public function destroy($id)
    {
        Category::where('id', $id)->delete();

        return response()->json([
            'message' => 'Category deleted!'
        ], 200);
    }


    // Custom functions

    public function getProducts($id) {
        $category = Category::where('id', $id)->with('products')->first();

        if(!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'category' => $category
        ], 200);
    }
}
