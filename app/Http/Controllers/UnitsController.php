<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{

    public function index()
    {
        $units = Unit::all();

        return response()->json([
            'message' => 'success',
            'units' => $units
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:units'
        ]);

        $unit = Unit::create($data);

        if(!$unit) {
            return response()->json([
                'message' => 'There was a problem adding the unit'
            ], 500);
        }

        return response()->json([
            'message' => 'Success',
            'unit' => $unit
        ], 201);

    }

    public function show($id)
    {
        $unit = Unit::where('id', $id)->first();

        if(!$unit) {
            return response()->json([
                'message' => 'The unit is not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Success',
            'unit' => $unit
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $unit = Unit::where('id', $id)->first();

        if(!$unit) {
            return response()->json([
                'message' => 'The unit is not found'
            ], 404);
        }

        $unit->name = $data['name'];
        $unit->save();

        if(!$unit) {
            return response()->json([
                'message' => 'There was a problem while updating the unit'
            ], 500);
        }

        return response()->json([
            'message' => 'Success',
            'unit' => $unit
        ], 200);
    }

    public function destroy($id)
    {
        $unit = Unit::where('id', $id)->delete();

        if(!$unit) {
            return response()->json([
                'message' => 'There was a problem while deleting the unit'
            ], 500);
        }

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}
