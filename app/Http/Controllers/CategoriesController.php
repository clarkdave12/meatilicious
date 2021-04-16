<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'category' => 'required|unique:categories',
            'image' => '',
            'base_url' => ''
        ]);

        if($validated['image']) {
            $validated['image_url'] = $this->decodeImage($validated['image'], $validated['base_url']);
        }
        else {
            $validated['image_url'] = $validated['base_url'] . '/images/defaults/meat.png';
        }

        $category = Category::create([
            'category' => $validated['category'],
            'image_url' => $validated['image_url'],
        ]);

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
            'category' => 'required',
            'image' => '',
            'base_url' => '',
        ]);

        $category = Category::where('id', $id)->first();

        $category->category = $validated['category'];

        if($validated['image']) {
            $category->image_url = $this->decodeImage($validated['image'], $validated['base_url']);
        }

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

    public function decodeImage($image, $baseURL) {

        $exploded = explode(',', $image);

            $decoded = base64_decode($exploded[1]);

            if(str_contains($exploded[0], 'jpeg') || str_contains($exploded[0], 'jpg'))
                $extension = 'jpg';
            else if(str_contains($exploded[0], 'png'))
                $extension = 'png';
            else
                return response()->json([
                    'message' => 'Invalid Image file'
                ], 422);

            $fileName = Str::random(15) . '.' . $extension;

            $path = public_path() . '/images' . '/' . $fileName;

            file_put_contents($path, $decoded);

            $image_url = $baseURL . '/images' . '/' . $fileName;

            return $image_url;
    }

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
