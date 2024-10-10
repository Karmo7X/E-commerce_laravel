<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $brands = Brands::paginate(10);
        return response()->json([
            'message' => 'Brands List',
            'brands' => $brands->items(),

        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brands|max:255',
            ]);
            $brand = new Brands();
            $brand->name=$request->name;
            $brand->save();
            return response()->json($brand, 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brands::find($id);
        if(!$brand){
            return response()->json(['message' => 'Brand not found'], 404);
        }
        else{
            return response()->json($brand, 200);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brands,name|max:255',
            ]);

            // Perform the update
            $brand = Brands::find($id); // Fetch the brand first

            if (!$brand) {
                return response()->json(['message' => 'Brand not found'], 404);
            }

            $brand->update(['name' => $request->name]); // Update the brand's name

            // Return the updated brand data in the response
            return response()->json([
                'message' => 'Brand updated successfully',
                'data' => $brand
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->errors()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand=Brands::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);

        } else {
            $brand->delete();
            return response()->json(['message' => 'Brand deleted successfully'], 200);
        }

    }
}
