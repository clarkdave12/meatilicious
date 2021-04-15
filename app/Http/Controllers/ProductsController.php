<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::orderBy('product_name', 'asc')->with('category')->get();

        return response()->json([
            'message' => 'success',
            'products' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'with_variant' => '',
            'images' => '',
            'category_id' => 'required'
        ]);

        if(!($validated['with_variant'] == 0 || $validated['with_variant'] == 1)) {
            return response()->json([
                'message' => 'Invalid with_variant format',
                'hint' => 'Only accepts Integer of value 1 or 0'
            ], 422);
        }

        $category = Category::where('id', $validated['category_id'])->first();

        if(!$category) {
            return response()->json([
                'message' => 'Invalid category_id'
            ], 422);
        }


        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created!',
            'product' => $product
        ], 201);
    }


    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        if(!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'product' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'with_variant' => '',
            'category_id' => 'required'
        ]);

        $category = Category::where('id', $validated['category_id'])->first();

        if(!$category) {
            return response()->json([
                'message' => 'Invalid category_id'
            ], 422);
        }


        $product = Product::where('id', $id)->first();

        $product->product_name = $validated['product_name'];
        $product->price = $validated['price'];
        $product->with_variant = $validated['with_variant'];
        $product->category_id = $validated['category_id'];
        $product->save();

        return response()->json([
            'message' => 'Product updated!',
            'product' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->delete();

        if($product) {
            return response()->json([
                'message' => 'Product deleted!'
            ], 200);
        }

        return response()->json([
            'message' => 'Could not delete the product'
        ], 500);
    }
}
