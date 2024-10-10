<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Log;
use Psy\Readline\Hoa\FileException;
use Illuminate\Support\Facades\File;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return response()->json(
            [
                'message' => 'Category List',
                'data' => $categories->items(),
            ]
            , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'cat_name' => 'required|unique:categories|max:255',
                'cat_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            // Create a new category instance
            $category = new Category();

            // Check if an image file was uploaded
            if ($request->hasFile('cat_image')) {
                // Set the path to the existing image (if any)
                $existingImagePath = 'storage/category/' . $category->cat_image;

                // Check if the existing image file exists and delete it
                if (File::exists(public_path($existingImagePath))) {
                    File::delete(public_path($existingImagePath));
                }

                // Handle the new image upload
                $file = $request->file('cat_image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;

                try {
                    // Move the uploaded file to the storage directory
                    $file->move(public_path('storage/category/'), $filename);
                    // Save the filename to the category
                    $category->cat_image = $filename; // Ensure this line is added
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()], 500);
                }
            }

            // Set the category name and save it
            $category->cat_name = $request->cat_name;
            $category->save();

            return response()->json([
                'message' => 'Category Added Successfully',
                'data' => $category,
            ], 200);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Return generic error message
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=Category::find($id);
        if(!$category){
          return response()->json([
              'message' => 'Category Not Found',
          ],404);
        }
        else{
            return response()->json(
                [
                    'message' => 'Category Detail',
                    'data' => $category,
                ]
                ,200
            );
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            // Validate incoming request data
            $validate = $request->validate([
                'cat_name' => 'required|unique:categories,cat_name|max:255',
                'cat_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Make cat_image nullable
            ]);

           $category =Category::find($id);
            if ($request->hasFile('cat_image')) {
                // Set the path to the existing image (if any)
                $existingImagePath = 'storage/category/' . $category->cat_image;

                // Check if the existing image file exists and delete it
                if (File::exists(public_path($existingImagePath))) {
                    File::delete(public_path($existingImagePath));
                }

                // Handle the new image upload
                $file = $request->file('cat_image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;

                try {
                    // Move the uploaded file to the storage directory
                    $file->move(public_path('storage/category/'), $filename);
                    // Save the filename to the category
                    $category->cat_image = $filename; // Ensure this line is added
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->errors()], 500);
                }
            }
           $category->cat_name=$request->cat_name;
           $category->update();
            return response()->json([
                'message' => 'Category Updated Successfully',
                'data' => $category,
            ],
                200
            );
        }catch (\Exception $e) {
            return response()->json($e->errors(), 500);
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        if(!$category){
            return response()->json([
                'message' => 'Category Not Found',
            ],404);
        }
        else{
            $category->delete();
            return response()->json([
                'message' => 'Category Deleted Successfully',
                'data' => $category,
            ],200);
        }
    }
}
