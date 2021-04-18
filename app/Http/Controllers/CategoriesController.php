<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'success',
            'categories' => $categories
        ], 200);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|unique:categories',
            'image' => ''
        ]);

        $host = $request->getHttpHost();
        $helper = new Helpers();

        if($request->image) {
            $data['image_url'] = $helper->decodeImage($data['image'], $host);
        }
        else {
            $data['image_url'] = $helper->base . $host . '/images/defaults/no_image.png';
        }

        $category = Category::create([
            'name' => $data['name'],
            'image_url' => $data['image_url']
        ]);

        return response()->json([
            'message' => 'Category Created',
            'category' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->first();

        return response()->json([
            'message' => 'success',
            'category' => $category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => '',
            'url' => ''
        ]);

        $host = $request->getHttpHost();
        $helper = new Helpers();

        $category = Category::where('id', $id)->first();

        $category->name = $data['name'];
        if($request->image) {
            $category->image_url = $helper->decodeImage($data['image'], $host);
        }

        $category->save();

        return response()->json([
            'message' => 'Success',
            'category' => $category
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->delete();

        if(!$category) {
            return response()->json([
                'message' => 'Could not delete the category',
            ], 422);
        }

        $subCategories = SubCategory::where('category_id', $id)->get();
        if($subCategories) {
            SubCategory::where('category_id', $id)->delete();
        }

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}
