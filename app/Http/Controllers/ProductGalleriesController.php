<?php

namespace App\Http\Controllers;

use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleriesController extends Controller
{
    public function removeImage(Request $request)
    {
        $image = ProductGallery::where('product_id', $request->id)
                            ->where('image_url', $request->url)->delete();

        if(!$image) {
            return response()->json([
                'message' => 'Could not delete the image'
            ], 422);
        }

        return response()->json([
            'message' => 'Deleted'
        ], 200);
    }
}
