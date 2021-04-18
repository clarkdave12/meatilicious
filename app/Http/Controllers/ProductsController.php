<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::with('prices')->with('images')->get();

        foreach($products as $product) {
            foreach($product['prices'] as $price) {
                $unit = Unit::where('id', $price['unit_id'])->first();
                $price['unit'] = $unit;
            }
        }

        return response()->json([
            'message' => 'Success',
            'products' => $products
        ], 200);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|unique:products',
            'sub_category_id' => 'required',
            'prices' => 'required',
            'images' => ''
        ]);

        $product = Product::create([
            'name' => $data['name'],
            'sub_category_id' => $data['sub_category_id']
        ]);

        if(!$product) {
            return response()->json([
                'Message' => 'There is problem addding the product'
            ], 500);
        }

        if($request->prices) {
            foreach($data['prices'] as $price) {
                Price::create([
                    'product_id' => $product->id,
                    'price' => $price['price'],
                    'per' => $price['per'],
                    'unit_id' => $price['unit']['id']
                ]);
            }
        }

        $helper = new Helpers();
        $host = $request->getHttpHost();

        if($request->images) {
            foreach($data['images'] as $image) {
                ProductGallery::create([
                    'product_id' => $product->id,
                    'image_url' => $helper->decodeImage($image, $host)
                ]);
            }
        }

        $prices = Price::where('product_id', $product->id)->get();
        $product->prices = $prices;
        $images = ProductGallery::where('product_id', $product->id)->get();
        $product->images = $images;

        return response()->json([
            'message' => 'Success',
            'product' => $product
        ], 201);

    }

    public function show($id)
    {
        $product = Product::where('id', $id)->with('prices')->with('images')->first();

        if(!$product) {
            return response()->json([
                'message' => 'No such product'
            ], 404);
        }

        foreach($product->prices as $price) {
            $unit = Unit::where('id', $price->unit_id)->first();
            $price->unit = $unit;
        }

        $subCategory = SubCategory::where('id', $product->sub_category_id)->first();
        $product->sub_category = $subCategory;

        $category = Category::where('id', $product->sub_category->category_id)->first();
        $product->category = $category;

        return response()->json([
            'message' =>'Success',
            'product' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'sub_category_id' => 'required',
            'prices' => 'required',
            'images' => ''
        ]);

        $product = Product::where('id', $id)->first();
        $product->name = $data['name'];
        $product->sub_category_id = $data['sub_category_id'];
        $product->save();

        foreach($data['prices'] as $pr) {
            $price = Price::where('id', $pr)->first();
            if($price->product_id = $id) {
                $price->price = $pr['price'];
                $price->per = $pr['per'];
                $price->unit_id = $pr['unit']['id'];
                $price->save();
            }
        }

        $helper = new Helpers();
        $host = $request->getHttpHost();

        for($i = 0; $i < count($data['images']); $i++) {
            $gallery = ProductGallery::where('image_url', $data['images'][$i])->first();
            if(!$gallery) {
                ProductGallery::create([
                    'product_id' => $id,
                    'image_url' => $helper->decodeImage($data['images'][$i], $host)
                ]);
            }
        }

        $product->prices = Price::where('product_id', $product->id)->get();
        $product->images = ProductGallery::where('product_id', $product->id)->get();

        return response()->json([
            'message' => 'Success',
            'product' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->delete();

        if(!$product) {
            return response()->json([
                'message' => 'There was a problem while deleting the product'
            ], 500);
        }

        return response()->json([
            'message' => 'Success'
        ], 200);
    }

}
