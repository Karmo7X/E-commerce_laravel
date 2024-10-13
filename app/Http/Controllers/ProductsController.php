<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products=Products::paginate(10);
        if(!$products){
            return response()->json([
                'message'=>'No products found',
            ],404);
        }else{
            return response()->json([
                'message'=>'Products list',
                'products'=>$products->items()
            ],200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation=$request->validate([
                'name'=>'required|max:255|min:3|unique:proudcts,name',
                'description'=>'required|max:255|min:3',
                'price'=>'required|max:255|min:3|numeric',
                'category_id'=>'required|numeric',
                'brand_id'=>'required|numeric',
                'quantity'=>'required|numeric',
                'image'=>'required|image|mimes:jpeg,png,jpg',

            ]);
            $product=new Products();
            $product->name=$request->name;
            $product->description=$request->description;
            $product->price=$request->price;
            $product->category_id=$request->category_id;
            $product->brand_id=$request->brand_id;
            $product->quantity=$request->quantity;
            if($request->hasFile('image')){
                $path='storage/products/'. $product->image;
                if(File::exists(public_path($path))){
                    File::delete(public_path($path));
                }

                // Handle the new image upload
                $file=$request->file('image');
                $extension=$file->getClientOriginalExtension();
                $filename =time(). '.' .$extension;
                try {
                    // Move the uploaded file to the storage directory
                    $file->move(public_path('storage/category/'), $filename);
                    // Save the filename
                    $product->image = $filename; // Ensure this line is added
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()], 500);
                }
            }
            $product->save();
           return  response()->json([
               'message'=>'Product created',
               'product'=>$product
           ],200);
        }catch (\Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage()
            ],500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Products::find($id);
        if(!$product){
            return response()->json([
                'message'=>'No product found',
            ],404);
        }else{
            return response()->json([
                'message'=>'Product details',
                'product'=>$product
            ],200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation=$request->validate([
                'name'=>'required|max:255|min:3',
                'description'=>'required|max:255|min:3',
                'price'=>'required|max:255|min:3|numeric',
                'category_id'=>'required|numeric',
                'brand_id'=>'required|numeric',
                'quantity'=>'required|numeric',
                'image'=>'required|image|mimes:jpeg,png,jpg',

            ]);
            $product =Products::find($id);
            if(!$product){
                return response()->json([
                    'message'=>'No product found',
                ],404);
            }else{

                $product->name=$request->name;
                $product->description=$request->description;
                $product->price=$request->price;
                $product->category_id=$request->category_id;
                $product->brand_id=$request->brand_id;
                $product->quantity=$request->quantity;
                if($request->hasFile('image')){
                    $path='storage/products/'. $product->image;
                    if(File::exists(public_path($path))){
                        File::delete(public_path($path));
                    }

                    // Handle the new image upload
                    $file=$request->file('image');
                    $extension=$file->getClientOriginalExtension();
                    $filename =time(). '.' .$extension;
                    try {
                        // Move the uploaded file to the storage directory
                        $file->move(public_path('storage/category/'), $filename);
                        // Save the filename
                        $product->image = $filename; // Ensure this line is added
                    } catch (\Exception $e) {
                        return response()->json(['message' => $e->getMessage()], 500);
                    }
                }
                $product->save();
                return response()->json([
                    'message'=>'Product updated',
                    'product'=>$product
                    ],200);
            }

        }catch (\Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product =Products::where('id',$id);
        if(!$product){
            return response()->json([
                'message'=>'No product found',

            ],404);
        }else{
            $product->delete();
            return response()->json([
                'message'=>'Product deleted',

            ],200);
        }
    }
}
