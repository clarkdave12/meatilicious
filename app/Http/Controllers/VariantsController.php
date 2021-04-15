<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;

class VariantsController extends Controller
{

    public function index()
    {
        $variants = Variant::orderBy('variant', 'asc')->get();

        if(!$variants) {
            return response()->json([
                'message' => 'No Variants yet'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'variants' => $variants
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'variant' => 'required|unique:variants',
            'multiplier' => 'required'
        ]);

        $variant = Variant::create($validated);

        return response()->json([
            'message' => 'New variant created',
            'variant' => $variant
        ], 201);
    }

    public function show($id)
    {
        $variant = Variant::where('id', $id)->first();

        if(!$variant) {
            return response()->json([
                'message' => 'Variant not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'variant' => $variant
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'variant' => 'required|unique:variants',
            'multiplier' => 'required'
        ]);

        $variant = Variant::where('id', $id)->first();

        $variant->variant = $validated['variant'];
        $variant->multiplier = $validated['multiplier'];
        $variant->save();

        return response()->json([
            'message' => 'Variant updated!',
            'variant' => $variant
        ], 200);
    }

    public function destroy($id)
    {
        $variant = Variant::where('id', $id)->delete();

        if(!$variant) {
            return response()->json([
                'message' => 'Could not delete variant'
            ], 422);
        }

        return response()->json([
            'message' => 'Variant deleted'
        ], 200);
    }
}
