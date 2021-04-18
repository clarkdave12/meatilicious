<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::all();

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
            'prices' => ''
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
                    'unit' => $price['unit']
                ]);
            }
        }

        $prices = Price::where('product_id', $product->id)->get();
        $product->prices = $prices;

        return response()->json([
            'message' => 'Success',
            'product' => $product
        ], 201);

    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        if(!$product) {
            return response()->json([
                'message' => 'No such product'
            ], 404);
        }

        return response()->json([
            'message' =>'Success',
            'product' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:products',
            'sub_category_id' => 'required',
            'prices' => 'required'
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
                $price->unit = $pr['unit'];
                $price->save();
            }
        }

        $product->prices = Price::where('id', $product->id)->get();

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
