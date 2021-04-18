<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoriesController extends Controller
{

    public function index()
    {
        $subCategories = SubCategory::all();

        foreach($subCategories as $sub) {
            $category = Category::where('id', $sub['category_id'])->first();
            $sub->category = $category;
        }

        return response()->json([
            'message' => 'Success',
            'sub_categories' => $subCategories
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:sub_categories',
            'category_id' => 'required',
            'image' => '',
            'url' => ''
        ]);

        $host = $request->getHttpHost();
        $helper = new Helpers();

        if($request->image) {
            $data['image_url'] = $helper->decodeImage($data['image'], $host);
        }
        else {
            $data['image_url'] = $helper->base .  $host . '/images/defaults/no_image.png';
        }

        $category = Category::where('id', $data['category_id'])->first();
        if(!$category) {
            return response()->json([
                'message' => 'Invalid category_id'
            ], 422);
        }

        $subCategory = SubCategory::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'image_url' => $data['image_url']
        ]);

        return response()->json([
            'message' => 'Success',
            'Sub category' => $subCategory
        ], 201);
    }

    public function show($id)
    {
        $subCategory = SubCategory::where('id', $id)->first();

        if(!$subCategory) {
            return response()->json([
                'message' => 'Sub category not found'
            ], 404);
        }

        $category = Category::where('id', $subCategory->category_id)->first();
        $subCategory->category = $category;

        return response()->json([
            'message' => 'Success',
            'sub_category' => $subCategory
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'image' => '',
        ]);

        $host = $request->getHttpHost();
        $helper = new Helpers();

        $subCategory = SubCategory::where('id', $id)->first();
        $subCategory->name = $data['name'];
        $subCategory->category_id = $data['category_id'];

        if($request->image) {
            $subCategory->image_url = $helper->decodeImage($data['image'], $host);
        }

        $subCategory->save();

        return response()->json([
            'message' => 'Success',
            'Sub category' => $subCategory
        ], 200);
    }

    public function destroy($id)
    {
        $subCategory = SubCategory::where('id', $id)->delete();

        if(!$subCategory) {
            return response()->json([
                'message' => 'Could not delete Sub category'
            ], 422);
        }

        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    // Custom class
    public function getSubCategoryByCategoryId($id) {
        $subCategory = SubCategory::where('category_id', $id)->get();
        if(!$subCategory) {
            return response()->json([
                'message' => 'No sub category for this category',
                'sub_categories' => $subCategory
            ]);
        }

        return response()->json([
            'message' => 'Success',
            'sub_categories' => $subCategory
        ], 200);
    }
}
